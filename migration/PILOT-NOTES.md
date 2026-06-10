# Pilot Notes — br/story-banner (Phase 0)

Result: **PASS** — both home-page story banners + spacers render DOM-identical to golden
(`compare.php` gates green). These notes are the build rules for all remaining components.

## Gotchas discovered & resolved

1. **ACF Pro download endpoints 404** (both legacy `index.php?a=download` and `/v2/plugins/download`).
   → Install from a manually downloaded zip: `wp plugin install <zip> --activate`.
   License key lives in `wp-config.php` as `ACF_PRO_LICENSE` (gitignored — never commit it).
   The plugin *code* is committed to the repo so it deploys at cutover; prod license
   activation happens in prod wp-admin at cutover.

2. **WP's big-image threshold silently corrupts large imports.** `wp media import` of the
   2728px farmtable produced a 2560px `-scaled` copy as the canonical URL — breaking both
   checksum identity and the hero pan keyframe math (which depends on exact 2728px width).
   → `add_filter( 'big_image_size_threshold', '__return_false' )` added to functions.php.
   If an asset was imported before the filter: delete attachment (`wp post delete <id> --force`)
   and re-import.

3. **Always run the checksum gate after importing assets** (`compare.php --checksum=<map>`)
   to prove the media-library copy is byte-identical to the original.

4. **URLs in templates must be path-relative** to match legacy markup and stay
   environment-portable: `wp_make_link_relative( get_field( 'image' ) )`.

5. **ACF block data is hand-authorable in post_content.** Format:
   `<!-- wp:acf/story-banner {"name":"acf/story-banner","data":{"field_name":"value","_field_name":"field_key",...},"mode":"edit"} /-->`
   Image fields store the attachment ID; ACF formats to URL via the field-key reference.
   This makes programmatic population (and the eventual content-replacement cutover) clean.

6. **acf-json works without touching wp-admin.** Hand-written
   `acf-json/group_*.json` files are loaded automatically by ACF from the theme dir.
   Field keys are ours to define (`field_brsb_*` convention: br + component initials).

7. **Block output is exactly the render template output** — no wrapper divs — when
   registered with `supports: align=false, anchor=false`. Verified by the DOM gate.

8. **Rebuild pages render in `page.html`, not `front-page.html`** — the entry-content
   wrapper differs (e.g. `alignfull` class). Expected; row-scoped gates don't see it.
   The wrapper variable disappears at the Phase 6 content-replacement gate.

9. **Escaping is safe under the DOM gate.** `esc_html()`/`esc_url()` may emit entities
   where golden has literals (or vice versa) — the DOM gate normalizes both sides.

10. **Editor placeholder pattern:** templates short-circuit with a friendly admin-only
    placeholder when required fields are empty (`is_admin()` guard) — invisible on front-end.

## Asset map & deploy reminder

- `migration/tools/asset-map.txt` is the canonical old→new URL registry. Every imported
  asset gets a row. The DOM gate consumes it via `--map`; the checksum gate via `--checksum`.
- **Imported media files live in `wp-content/uploads/2026/06/` — they must go up via
  `./sync-uploads.sh` at cutover** (uploads aren't in git). Added to the cutover checklist.

## Still open (pilot scope)

- Visual pixel gate not yet automated — for the pilot, eyeball `/home-rebuild/` vs `/`
  locally. Screenshot tooling decision deferred to early Phase 1.
