# Blue Raeven Farms — SEO Foundation at Launch

**Prepared by Brilliance NW**

This document summarizes the search engine optimization (SEO) and AI-search readiness work built into the new Blue Raeven Farms website. Each item below is an established best practice that contributes to discoverability in Google search, AI assistants (ChatGPT, Perplexity, Claude, Gemini), and local "near me" results.

The site launches with a strong technical SEO foundation that puts Blue Raeven Farms ahead of the vast majority of small-business websites — the kind of foundation that compounds over time as content and inbound links grow.

---

## Crawlability & Discovery

**XML Sitemap.** Auto-generated at `/wp-sitemap.xml` listing every public page. Ready to be submitted to Google Search Console and Bing Webmaster Tools at launch.

**Robots.txt.** Properly configured — search engines and AI crawlers are explicitly welcome; nothing important is blocked.

**AI crawler access.** All major AI search crawlers — GPTBot (ChatGPT), PerplexityBot, ClaudeBot, Bingbot (Bing + ChatGPT web), Google-Extended (Gemini), and Applebot — are allowed to fetch and learn from the site. Many sites accidentally block these and disappear from AI search results.

**Clean, semantic URLs.** Human-readable paths like `/farmstand/`, `/story/`, `/pies-more/pies/` instead of opaque query strings.

**`llms.txt` published.** A site summary file in the emerging AI-search standard, served at `/llms.txt`. Tells AI assistants what the site is about, lists the key pages, and includes business facts (founding year, locations, hours, product list). As of 2026, fewer than 5% of small-business sites have this — early-adopter advantage.

**301 redirects from the old site.** Every meaningful URL from `blueraevenfarmstand.com` (`/about/`, `/contact.html`, `/baking-instructions/`, `/shop/*`, `/product/*`, etc.) redirects permanently to its new equivalent. No lost search equity, no broken external links, no "page not found" gaps.

## On-Page Optimization

**Unique page titles** on every page (e.g., "Our Story – Blue Raeven Farmstand"), matched to the current brand.

**Custom meta descriptions** written individually for each of the 10 indexable pages. Search-result snippets are crafted — not auto-generated — to read as compelling, informative descriptions.

**Self-referencing canonical tags** on every page. Prevents duplicate-content penalties and consolidates ranking signals.

**Proper heading hierarchy.** Every page has exactly one H1, supported by H2 section headings and H3 sub-sections in semantic order.

**Descriptive alt text** on every content image. Improves accessibility and helps search engines understand image context.

## Structured Data (Schema.org / JSON-LD)

**Organization schema** sitewide. Identifies the brand, links to logo, founding date (1928), and Facebook + Instagram profiles. Helps search engines and AI systems recognize Blue Raeven Farms as a verified business entity.

**LocalBusiness (Bakery) schemas** on the Farmstand page for *both* the Amity Farmstand and McMinnville Pie Company. Each includes full street address, telephone, opening hours, and image. This is what powers:
- Google Maps Knowledge Panels
- "Pie shop near me in McMinnville" voice / AI results
- Structured location data in ChatGPT and Perplexity responses

**WebSite schema** on the homepage. Establishes the brand domain and prepares the site for advanced Google features (e.g., sitelinks search box).

## Mobile & Accessibility

**Mobile-first responsive design** with breakpoints at tablet (900px) and mobile (600px). Google has crawled the web mobile-only since 2024 — mobile-friendliness is no longer optional.

**Viewport meta tag** correctly configured so layouts adapt to phone screens.

**Tap-friendly UI.** Buttons, links, and form controls sized appropriately for touch.

**WCAG-aware contrast.** Script subheads on photo backgrounds use a navy overlay and text-shadow to ensure readability.

## Performance (Core Web Vitals)

**Cloudflare CDN** sits in front of the WPEngine hosting. Edge caching delivers pages from the data center geographically closest to each visitor.

**HTTP/3 support** via Cloudflare. Faster initial handshake and parallel loading on modern browsers.

**HTTPS enforced everywhere.** Required for ranking, trust signals, and modern browser features.

**Fast Time-to-First-Byte** (~110ms in benchmarks). Pages start streaming nearly instantly.

**Server-side rendering.** Every page's content is present in the initial HTML response. This is critical for AI crawlers, which do *not* execute JavaScript. Many modern sites built with React/Vue/Angular fail this test and become invisible to ChatGPT, Perplexity, and Claude. Blue Raeven Farms passes it completely.

**Lazy-loaded images** below the fold (`loading="lazy"`). Initial page load downloads less.

**Asynchronous image decoding** (`decoding="async"`). Images don't block the main thread.

**Optimized image assets.** All photos resized to web-appropriate dimensions, EXIF metadata stripped, JPEG quality tuned (80-85). Typical 50-70% file-size reduction from camera originals.

## Content & Site Architecture

**Logical page hierarchy.** Top-level navigation maps to top-level pages; sub-pages nest intuitively (`/pies-more/pies/`, `/pies-more/jams-spreads/`, etc.).

**Internal linking.** Calls-to-action across the site funnel visitors to key destinations (Story, Pies, Farmstand, Wholesale).

**Block-based content.** Pages are composed from reusable Gutenberg patterns, making future content updates and additions consistent — both visually and in terms of SEO compliance.

## Analytics & Measurement

**Google Tag Manager** installed sitewide (container `GTM-N79LWGKC`). Enables future analytics tags (Google Analytics 4, conversion tracking, A/B tests, Meta Pixel, etc.) to be added through the GTM interface without further developer involvement.

## Local SEO

**Both physical locations** (Amity Farmstand + McMinnville Pie Company) are marked up as `Bakery` LocalBusiness entities with full NAP (Name, Address, Phone) data and opening hours.

**City names in content.** "Amity, Oregon" and "McMinnville, OR" appear naturally throughout titles, descriptions, and page copy — reinforcing local relevance.

**Brand consistency.** Site title, page titles, schema, and `llms.txt` all use "Blue Raeven Farms" / "Blue Raeven Farmstand" consistently.

## Migration & Continuity

**Legacy URL preservation.** Visitors with bookmarks or external links to the old `blueraevenfarmstand.com` URLs land on the correct new page automatically. The 301 redirect type tells search engines "this content moved permanently," preserving accumulated SEO value.

**No "page not found" gaps** for common old paths — old product pages, shop pages, hours-and-directions, baking instructions, and contact pages all redirect cleanly.

---

## What this means for ranking and visibility

Taken together, these features mean Blue Raeven Farms ships with:

1. **A solid technical foundation.** Search engines and AI crawlers can find, fetch, parse, and understand every page.
2. **Local SEO readiness.** Both store locations are marked up properly for Google Maps and "near me" search queries from day one.
3. **AI-search readiness.** Content is in raw HTML (no JavaScript gating), structured data identifies the entity and locations, and the `llms.txt` file gives AI assistants a curated overview.
4. **Migration safety.** Existing search equity, bookmarks, and inbound links from the old domain continue to work.

---

## What comes next

The launch foundation is in place. The natural next layer of SEO growth — none required at launch, but worth budgeting for over the coming quarters:

- **Content marketing** — recipes, baking tips, seasonal updates, farm stories. Each post adds another doorway for relevant search queries (and another piece of content that AI systems can cite).
- **Google Business Profile** — claim and verify both Amity and McMinnville locations in Google Business Profile so they appear in Google Maps with reviews, photos, and posts.
- **Bing Places for Business** — same for Bing, which powers ChatGPT web search.
- **Link building** — partnerships, press mentions, and supplier relationships (regional grocers, farm associations, Oregon tourism boards) generate backlinks that compound ranking authority.
- **Customer reviews** — visible Google Maps and Yelp reviews influence both human visitors and AI summaries of the business.
- **Seasonal content updates** — refreshing key pages (especially the Farmstand and Pies pages) reflects WordPress's `lastmod` dates in the sitemap, prompting search engines to re-crawl and surface fresh content.

---

*Site launched on the foundation described above. Document prepared at launch for client reference.*
