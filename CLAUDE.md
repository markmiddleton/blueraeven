# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Blue Raeven Farm Stand — a WordPress site for an Oregon pie company, hosted on WPEngine. The repo is the full WordPress install, but only the custom theme and tracked plugins are version-controlled. Everything else (core, uploads, config) is owned by WPEngine and is gitignored.

The site is a Gutenberg block theme with Full Site Editing — there is no PHP templating for page layouts; pages are composed from block patterns inside `wp-admin`.

## Deployment

Two remotes:
- `origin` → `github.com:markmiddleton/blueraeven.git` (source of truth)
- `wpengine` → `git.wpengine.com:blueraeven.git` (auto-deploys on push)

Workflow: develop on `main`, then `git push wpengine main` — WPEngine deploys automatically from the push, no manual step needed. The `main-wpengine` branch tracks what's live in production.

Media (`wp-content/uploads/`) is not in git. To push local uploads to production, use `./sync-uploads.sh` — it runs `rsync` with a dry-run preview and prompts before transferring. It is additive (no `--delete`).

SSH: `blueraeven@blueraeven.ssh.wpengine.net`

## Database workflow

**Never make DB changes directly on production.** All content/option/menu edits happen on the local install; the user manually copies the local DB to production when ready.

This means:
- Use `wp @local <command>` for any write operation (`post update`, `option update`, `menu item add-post`, imports, etc.).
- `wp @production <command>` is **read-only** — only use it to inspect live state (e.g. `wp @production post list`, `wp @production option get`).
- If a change can't be done in PHP/templates and requires the DB, do it locally and tell the user it's ready to copy up.

## WP-CLI

`wp-cli.yml` defines two aliases:

```bash
wp @local <command>        # runs against local install — use for all writes
wp @production <command>   # runs against live site over SSH — read-only inspection only
```

Useful references:
- Main Menu ID: `5` (`wp @local menu item list 5`)
- Pages list: `wp @local post list --post_type=page --fields=ID,post_title,post_name`

## Theme Architecture

All custom work lives in `wp-content/themes/blue-raeven-theme/`. **The theme has its own nested git repo** (`.git` ignored by the parent) — be aware of which repo you're committing to.

### How a page gets rendered

1. WordPress picks a template from `templates/*.html` (e.g. `page-visit.html`, `front-page.html`, `single-product.html`).
2. The template references `parts/header.html` and `parts/footer.html`, plus inline `<!-- wp:pattern {"slug":"..."} -->` references.
3. Patterns are PHP files in `patterns/` (numbered `01-` through `37-`). Each has a header comment (`Title:`, `Slug:`, `Categories:`) and emits Gutenberg block markup.
4. Styles come from a single `assets/css/theme.css` (cache-busted via `filemtime`) plus `theme.json` design tokens.

### Pattern registration quirk

Patterns numbered 01–28 are auto-discovered by WordPress from the `patterns/` directory. Patterns **29–37 are manually registered** inside `functions.php` (`blue_raeven_register_block_patterns`) because they weren't auto-loading. When adding a new pattern past `28-`, either ensure it auto-loads or add its slug to the `$manual_patterns` array in `functions.php`.

Pattern categories used for the inserter: `blue-raeven`, `blue-raeven-global`, `blue-raeven-heroes`, `blue-raeven-content`, `blue-raeven-cards`, `blue-raeven-ctas`, `blue-raeven-lists`.

### Custom post types and ACF

- **Products CPT** (`inc/class-cpt-products.php`) — internally referred to as "Pies".
- **ACF Pro** is an expected dependency. `functions.php` registers two ACF blocks (`product-card`, `product-grid`, rendered from `blocks/*.php`) and an ACF options page ("Theme Settings"). All of this is wrapped in `function_exists()` checks, so the theme degrades gracefully if ACF is absent — but blocks won't render.

### Design system (theme.json)

| Color | Hex | |
|-------|-----|---|
| Navy / Navy Deep | `#1a3a6b` / `#0f2545` | Primary, dark sections |
| Gold / Gold Light | `#d4a853` / `#e8c878` | Accents, hover |
| Cream / Cream Warm | `#faf3e6` / `#f5ead0` | Backgrounds |
| Berry | `#8a2040` | Script text |
| Green | `#4a7637` | Secondary CTAs |
| Aqua | `#5bbfcf` | Accent text |

Fonts:
- **Adobe Typekit** (`https://use.typekit.net/spx7fio.css`): Citrus Gothic, Hanley Block, Hanley Slim Sans, Futura Condensed — loaded via `wp_enqueue_style` *and* `add_editor_style` so they appear in the block editor too.
- **Local fonts** (`assets/css/fonts.css`): Nexa Rust Script.
- The theme README lists Google fonts (Oswald, Lora, Inter, Shadows Into Light) but the actual enqueued stack is Typekit + Nexa Rust — treat the README as stale on this point.

### Font-face stripping (gotcha)

`functions.php` wraps the whole page in an output buffer (`blue_raeven_filter_font_face`) that strips any `@font-face` block referencing `fonts.gstatic.com`. This is a workaround for WordPress caching outdated gstatic URLs from earlier theme versions. It also removes `fontFace` entries from `theme.json` via the `wp_theme_json_data_theme` filter and unhooks `wp_print_font_faces`. If you add a legitimate `@font-face` rule that needs to survive, be aware of this filter.

### Custom image sizes

Registered in `functions.php`: `product-card` (600×450), `product-card-large` (800×600), `hero-banner` (1920×800), `gallery-thumb` (400×300). These are selectable in the media library.

### Custom block styles

Registered for `core/button` (`berry`, `green`) and `core/group` (`navy-section`, `cream-section`).

## Image Generator

`image-generator/` is a standalone Python script for generating torn-paper background PNGs used as section dividers/textures. It is not part of the WordPress runtime.

```bash
cd image-generator
source venv/bin/activate
python generate_image.py
```

## Editing tips

- For layout/content changes, prefer editing patterns and `theme.json` over inline styles. The single source of CSS is `assets/css/theme.css`.
- After editing `theme.css`, no version bump is needed — `filemtime` cache-busts automatically.
- After editing `functions.php` or any PHP, bump `BLUE_RAEVEN_VERSION` if you want to bust style/script caches that don't use `filemtime`.
- Templates and patterns are HTML/PHP files — they are not edited through the WordPress admin once shipped via the theme.
