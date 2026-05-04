# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Blue Raeven Farm Stand - A WordPress site for an Oregon pie company, using a custom Gutenberg block theme with Full Site Editing. Hosted on WPEngine.

## Deployment Architecture

- **Git Remotes**: `origin` (GitHub) and `wpengine` (production)
- **Production**: Push to `wpengine` remote deploys to WPEngine
- **Branch**: `main` for development, `main-wpengine` tracks production

## WP-CLI Commands

The `wp-cli.yml` defines environment aliases:

```bash
# Run commands on production (live site)
wp @production <command>

# Run commands locally
wp @local <command>

# Examples
wp @production post list --post_type=page
wp @production menu item list 5
wp @production option get blogname
```

SSH access is configured: `blueraeven@blueraeven.ssh.wpengine.net`

## Theme Architecture

The custom theme is at `wp-content/themes/blue-raeven-theme/`:

### Key Files
- `theme.json` - Design tokens (colors, typography, spacing)
- `functions.php` - Theme setup, CPT registration, asset enqueuing
- `inc/class-cpt-products.php` - Products custom post type

### Design System (from theme.json)
| Color | Hex | Usage |
|-------|-----|-------|
| Navy | #1a3a6b | Primary, headers |
| Gold | #d4a853 | Accents, CTAs |
| Cream | #faf3e6 | Backgrounds |
| Berry | #8a2040 | Script text |

Typography: Citrus Gothic (display), Nexa Rust Script (script), Adobe fonts via Typekit

### Template Structure
- `templates/` - Full page templates (front-page.html, page-visit.html, etc.)
- `parts/` - Reusable parts (header.html, footer.html)
- `patterns/` - 37 block patterns (numbered 01-37, PHP files)

### Block Patterns
Patterns are PHP files that register Gutenberg block markup. Key patterns:
- `01-navigation-bar.php` - Site header
- `06-footer.php` - Site footer
- `07-hero-carousel.php` - Homepage hero
- `19-pie-card-grid.php` - Product cards

## Git Workflow

Only `wp-content/themes/` and `wp-content/plugins/` are tracked. WordPress core, uploads, and config are gitignored (managed by WPEngine).

The theme has its own nested git repo at `wp-content/themes/blue-raeven-theme/.git` (ignored by parent).

## Image Generator

`image-generator/` contains a Python script for generating torn paper background images:
```bash
cd image-generator
source venv/bin/activate
python generate_image.py
```

## Content Management via WP-CLI

Common content operations on production:

```bash
# Pages
wp @production post list --post_type=page --fields=ID,post_title,post_name

# Menus (Main Menu ID: 5)
wp @production menu item list 5
wp @production menu item add-post 5 <page_id> --title="Title"

# Options
wp @production option update blogdescription "New tagline"
```
