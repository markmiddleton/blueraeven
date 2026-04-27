# Blue Raeven Theme

A custom WordPress block theme for Blue Raeven Farm & Pie Stand, featuring block patterns, a Pies custom post type, and full site editing support.

## Features

- **Block Patterns** - 37+ pre-designed page sections that can be inserted and customized
- **Custom Post Type: Pies** - Manage your pie menu with custom fields for tags, pricing, and availability
- **Full Site Editing** - Edit header, footer, and templates directly in the WordPress editor
- **Design Tokens via theme.json** - Consistent colors and typography across the site
- **Live Preview Editing** - See changes as you make them in the block editor
- **No Page Builder Required** - Uses native WordPress blocks

## Requirements

- WordPress 6.4 or higher
- PHP 8.0 or higher
- Advanced Custom Fields Pro (ACF Pro) - for Pies custom fields (optional)

## Installation

1. Upload `blue-raeven-theme` to `/wp-content/themes/`
2. Activate the Blue Raeven theme
3. Install and activate ACF Pro (optional, for Pies custom fields)
4. Import demo content via Appearance > Import Demo Data (requires One Click Demo Import plugin)

## Block Patterns

The theme includes 37+ pre-designed block patterns in these categories:

### Global
- Navigation Bar - Fixed header with logo and nav
- Stripe Border - Decorative border accent
- Section Header - Centered header with label, title, script text
- Testimonial - Navy background quote with attribution
- Picket Fence - Decorative separator
- Footer - 4-column footer layout

### Heroes
- Hero Carousel - Full-screen rotating slides
- Page Hero - Navy background hero for inner pages
- Page Hero (Story/Contact/Farm Stand) - Page-specific variations
- Split Hero - 50/50 image and text layout
- Mosaic Hero - 2x2 grid with overlay
- Contact Hero Image - Photo with overlay text

### Content
- Features Grid - 4-column icon cards
- Story Block Left/Right - Image + text layouts
- Photo Banner - Full-width image strip
- Timeline - Vertical timeline with gold dots
- Image Gallery - Masonry 3-column grid
- Process Steps - Numbered 4-column steps
- Pie Feature Block - Alternating 50/50 sections

### Cards & Grids
- Pie Card Grid - Product cards with tags/prices
- Farm Stand Info Grid - Hours + info blocks
- What You'll Find Cards - 3-column offering cards
- Contact Methods Grid - Icon + link cards

### Forms & CTAs
- Contact Form Split - Navy form + image side
- CTA Banner - Centered text with buttons
- Seasonal Banner - Announcement strip
- Order Callout - Image + text CTA
- Social CTA - Follow along section

### Lists
- FAQ List - Q&A with gold bullets
- Social Links - Circular icon buttons

## Page Templates

| Template | Description |
|----------|-------------|
| `page-visit.html` | Farm Stand page |
| `page-story.html` | Our Story page |
| `page-pies.html` | Our Pies page |
| `page-contact.html` | Contact page |
| `front-page.html` | Homepage |
| `archive-product.html` | Products archive |
| `single-product.html` | Single product view |

## Design Tokens

### Colors (theme.json)

| Name | Hex Value | Usage |
|------|-----------|-------|
| Navy | `#1a3a6b` | Primary, headers |
| Navy Deep | `#0f2545` | Dark sections |
| Gold | `#d4a853` | Accents, CTAs |
| Gold Light | `#e8c878` | Hover states |
| Cream | `#faf3e6` | Backgrounds |
| Cream Warm | `#f5ead0` | Alt backgrounds |
| Berry | `#8a2040` | Script text, accents |
| Green | `#4a7637` | Secondary CTAs |
| Aqua | `#5bbfcf` | Accent text |

### Typography

| Role | Font | Weight |
|------|------|--------|
| Display | Oswald | 400-700 |
| Script | Shadows Into Light | 400 |
| Serif | Lora | 400, 700 |
| Body | Inter | 300-500 |

## File Structure

```
blue-raeven-theme/
├── style.css              # Theme header
├── functions.php          # Theme setup, CPT, patterns
├── theme.json             # Design tokens
├── README.md              # This file
├── screenshot.png         # Theme preview
├── inc/
│   └── class-cpt-products.php
├── templates/
│   ├── index.html
│   ├── front-page.html
│   ├── page.html
│   ├── page-visit.html
│   ├── page-story.html
│   ├── page-pies.html
│   ├── page-contact.html
│   ├── archive-product.html
│   └── single-product.html
├── parts/
│   ├── header.html
│   └── footer.html
├── patterns/
│   ├── 01-navigation-bar.php
│   ├── 02-stripe-border.php
│   ├── ... (37+ patterns)
├── blocks/
│   ├── product-card.php
│   └── product-grid.php
├── assets/
│   ├── css/theme.css
│   ├── js/theme.js
│   └── images/
└── demo-content/
    └── content.xml
```

## Changelog

### 2.0.0
- Complete rewrite as Gutenberg block theme
- Full Site Editing support
- 37+ block patterns
- Design tokens via theme.json
- Page-specific templates for all main pages

### 1.0.0
- Initial release (Elementor version)

## Credits

- Google Fonts: Oswald, Lora, Inter, Shadows Into Light
- Design & Development by [Brilliance NW](https://brilliancenw.com)

## License

GPL v2 or later
