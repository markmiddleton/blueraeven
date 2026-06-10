#!/usr/bin/env php
<?php
/**
 * compare.php — migration diff gate
 *
 * Compares a region of two HTML documents (golden vs rebuild) under the
 * project's exactness standard (MIGRATION-PLAN.md, Decision 1: DOM-strict).
 *
 * Usage:
 *   php compare.php --a=<file|url> --b=<file|url> [options]
 *
 * Options:
 *   --selector=SEL    Scope comparison to matching element. Supports:
 *                     tag, tag.class, .class, #id   (e.g. section.story-banner)
 *   --index-a=N       Which match to use on side A (default 0)
 *   --index-b=N       Which match to use on side B (default 0)
 *   --mode=dom|bytes  dom (default): DOM-equivalence — entities decoded,
 *                     inter-tag whitespace collapsed, attributes sorted,
 *                     comments ignored, script text line-trimmed.
 *                     bytes: raw byte diff of the (map-normalized) inputs.
 *   --map=FILE        Asset URL map, tab-separated "old<TAB>new" per line.
 *                     Old URLs are rewritten to new on both sides pre-compare.
 *   --checksum=FILE   Verify each map line: fetch old + new URL, compare
 *                     sha256 (asset integrity gate). No HTML comparison.
 *
 * Exit codes: 0 identical · 1 different · 2 usage/fetch error
 */

error_reporting(E_ALL & ~E_DEPRECATED);
libxml_use_internal_errors(true);

$opts = [];
foreach (array_slice($argv, 1) as $arg) {
    if (preg_match('/^--([a-z-]+)=(.*)$/', $arg, $m)) $opts[$m[1]] = $m[2];
}

function fetch(string $src): string {
    if (preg_match('#^https?://#', $src)) {
        $ctx = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $html = @file_get_contents($src, false, $ctx);
        if ($html === false) { fwrite(STDERR, "FETCH FAILED: $src\n"); exit(2); }
        return $html;
    }
    if (!is_readable($src)) { fwrite(STDERR, "UNREADABLE: $src\n"); exit(2); }
    return file_get_contents($src);
}

function load_map(?string $file): array {
    if (!$file) return [];
    $map = [];
    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if ($line[0] === '#') continue;
        $parts = explode("\t", $line);
        if (count($parts) === 2) $map[$parts[0]] = $parts[1];
    }
    return $map;
}

// ---- checksum mode -------------------------------------------------------
if (isset($opts['checksum'])) {
    $map = load_map($opts['checksum']);
    if (!$map) { fwrite(STDERR, "Empty/unreadable map\n"); exit(2); }
    $fail = 0;
    foreach ($map as $old => $new) {
        $ha = hash('sha256', fetch($old));
        $hb = hash('sha256', fetch($new));
        $ok = $ha === $hb;
        printf("%s  %s\n      -> %s\n", $ok ? 'OK  ' : 'FAIL', $old, $new);
        if (!$ok) $fail++;
    }
    echo $fail ? "\n$fail checksum mismatch(es)\n" : "\nAll mapped assets byte-identical\n";
    exit($fail ? 1 : 0);
}

// ---- comparison ----------------------------------------------------------
if (!isset($opts['a'], $opts['b'])) {
    fwrite(STDERR, "Usage: compare.php --a=<file|url> --b=<file|url> [--selector=...] [--mode=dom|bytes] [--map=FILE]\n");
    exit(2);
}

$map  = load_map($opts['map'] ?? null);
$mode = $opts['mode'] ?? 'dom';

$rawA = strtr(fetch($opts['a']), $map);
$rawB = strtr(fetch($opts['b']), $map);

function select_node(string $html, ?string $sel, int $index): ?DOMNode {
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    if (!$sel) return $doc->documentElement;
    $xp = new DOMXPath($doc);
    if ($sel[0] === '#') {
        $q = sprintf("//*[@id='%s']", substr($sel, 1));
    } elseif ($sel[0] === '.') {
        $q = sprintf("//*[contains(concat(' ',normalize-space(@class),' '),' %s ')]", substr($sel, 1));
    } elseif (strpos($sel, '.') !== false) {
        [$tag, $cls] = explode('.', $sel, 2);
        $q = sprintf("//%s[contains(concat(' ',normalize-space(@class),' '),' %s ')]", $tag, $cls);
    } else {
        $q = "//$sel";
    }
    $nodes = $xp->query($q);
    return ($nodes && $nodes->length > $index) ? $nodes->item($index) : null;
}

/** Canonical serialization for DOM-equivalence comparison. */
function canon(DOMNode $node, int $depth = 0): array {
    $pad = str_repeat('  ', $depth);
    $out = [];
    if ($node->nodeType === XML_ELEMENT_NODE) {
        $attrs = [];
        foreach ($node->attributes as $a) $attrs[$a->name] = $a->value;
        ksort($attrs);
        $astr = '';
        foreach ($attrs as $k => $v) $astr .= sprintf(' %s="%s"', $k, trim(preg_replace('/\s+/', ' ', $v)));
        $out[] = $pad . '<' . $node->nodeName . $astr . '>';
        $isScript = in_array($node->nodeName, ['script', 'style'], true);
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                if ($isScript) {
                    foreach (explode("\n", $child->textContent) as $line) {
                        $line = trim($line);
                        if ($line !== '') $out[] = $pad . '  |' . $line;
                    }
                } else {
                    $t = trim(preg_replace('/\s+/u', ' ', $child->textContent));
                    if ($t !== '') $out[] = $pad . '  "' . $t . '"';
                }
            } elseif ($child->nodeType === XML_ELEMENT_NODE) {
                $out = array_merge($out, canon($child, $depth + 1));
            }
            // comments, CDATA, PIs: ignored (not rendered)
        }
        $out[] = $pad . '</' . $node->nodeName . '>';
    }
    return $out;
}

$sel = $opts['selector'] ?? null;

if ($mode === 'bytes') {
    if ($rawA === $rawB) { echo "IDENTICAL (bytes)\n"; exit(0); }
    $fa = tempnam(sys_get_temp_dir(), 'cmpA'); $fb = tempnam(sys_get_temp_dir(), 'cmpB');
    file_put_contents($fa, $rawA); file_put_contents($fb, $rawB);
    passthru("diff -u " . escapeshellarg($fa) . " " . escapeshellarg($fb) . " | head -80");
    unlink($fa); unlink($fb);
    echo "\nDIFFERENT (bytes)\n"; exit(1);
}

$na = select_node($rawA, $sel, (int)($opts['index-a'] ?? 0));
$nb = select_node($rawB, $sel, (int)($opts['index-b'] ?? 0));
if (!$na) { fwrite(STDERR, "Selector '$sel' (index " . ($opts['index-a'] ?? 0) . ") not found in A\n"); exit(2); }
if (!$nb) { fwrite(STDERR, "Selector '$sel' (index " . ($opts['index-b'] ?? 0) . ") not found in B\n"); exit(2); }

$ca = implode("\n", canon($na));
$cb = implode("\n", canon($nb));

if ($ca === $cb) { echo "IDENTICAL (dom)\n"; exit(0); }

$fa = tempnam(sys_get_temp_dir(), 'cmpA'); $fb = tempnam(sys_get_temp_dir(), 'cmpB');
file_put_contents($fa, $ca . "\n"); file_put_contents($fb, $cb . "\n");
passthru("diff -u " . escapeshellarg($fa) . " " . escapeshellarg($fb) . " | head -120");
unlink($fa); unlink($fb);
echo "\nDIFFERENT (dom)\n"; exit(1);
