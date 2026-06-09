# GEO Technical SEO Audit — blueraevenfarms.com

Date: 2026-06-09

## ⚠️ Critical Blocker: Production is behind HTTP Basic Auth

Every URL on `https://blueraevenfarms.com/` returns **401 Authorization Required** with `WWW-Authenticate: Basic realm="blueraeven"`. This means:

- **No search engine (Google, Bing, etc.) can crawl or index any page.**
- **No AI crawler (GPTBot, PerplexityBot, ClaudeBot, Bingbot for ChatGPT) can fetch content.**
- **The site is invisible to all of public web discovery until this is removed.**

Until basic auth is lifted, the *de facto* technical SEO score is **0 / 100** — none of the underlying quality matters if crawlers can't reach the content. The score table below assumes auth has been removed and reflects what's deployed on prod (audited via the local mirror, which runs identical code).

---

## Technical Score: 67 / 100 (once auth is removed)

| Category | Score | Status |
|---|---|---|
| Crawlability | 13/15 | Pass |
| Indexability | 7/12 | Warn |
| Security | 6/10 | Warn |
| URL Structure | 8/8 | Pass |
| Mobile Optimization | 10/10 | Pass |
| Core Web Vitals | 7/15 | Warn |
| Server-Side Rendering | 15/15 | Pass |
| Page Speed & Server | 10/15 | Warn |

---

## AI Crawler Access

`robots.txt` is the WordPress default — `Disallow: /wp-admin/` only, with sitemap referenced. **No AI crawler is explicitly blocked.** Once basic auth is removed, all of these reach content:

| Crawler | Platform | Status |
|---|---|---|
| Googlebot | Google Search + AI Overviews | ✓ Allowed (gated by auth on prod) |
| GPTBot | ChatGPT | ✓ Allowed (gated) |
| Google-Extended | Gemini training | ✓ Allowed (gated) |
| Bingbot | Bing + ChatGPT web | ✓ Allowed (gated) |
| PerplexityBot | Perplexity | ✓ Allowed (gated) |
| ClaudeBot | Claude | ✓ Allowed (gated) |
| Applebot-Extended | Apple Intelligence | ✓ Allowed (gated) |

---

## Critical Issues (fix immediately)

### 1. Remove HTTP Basic Auth on production
- Confirm where the auth is configured (WPEngine "Password Protection" feature, or `.htaccess`, or Cloudflare Access).
- Disable it for the public site once the rebrand launch is greenlit.
- Without this, *nothing else in the audit matters.*

### 2. Page titles still say "Blue Raeven Farm Stand" — stale brand
- `wp option get blogname` returns `Blue Raeven Farm Stand` (the *old* business name).
- Every page title ends in this string. Examples:
  - `Our Story – Blue Raeven Farm Stand`
  - `Contact – Blue Raeven Farm Stand`
  - `Pies – Blue Raeven Farm Stand`
- Fix locally: `wp @local option update blogname "Blue Raeven Farms"` (or "Blue Raeven Farms Pie Company"). DB-only change, copies up with normal workflow.

### 3. No `<meta name="description">` on any page
- Verified zero meta descriptions across home, story, contact, farmstand, pies, wholesale.
- Without this, Google/Bing/AI generate snippets from page content — often suboptimal.
- Each top-level page needs a 140-160 character description with relevant keywords.
- Implementation options:
  - Install Yoast SEO or RankMath plugin (UI-based, easy for non-devs).
  - Add `wp_head` hook in `functions.php` that emits a `<meta name="description">` per page using ACF or a custom field.

### 4. Homepage has no `<h1>`
- The home page replaced its `<h1>Blue Raeven Farms Pie Company</h1>` text with the "PIE FIXES EVERYTHING" image graphic.
- The graphic has `alt="Pie Fixes Everything"` (good), but it's an `<img>`, not an `<h1>`. The home page now has zero H1 elements.
- Recommended fix: wrap the image in `<h1>`, or add a visually-hidden `<h1>Blue Raeven Farms Pie Company</h1>` near the top:
  ```html
  <h1 class="visually-hidden">Blue Raeven Farms Pie Company</h1>
  ```
- All inner pages have proper H1s (Our Story, Get In Touch, etc.) — only the home is missing.

### 5. No Open Graph or Twitter Card meta tags
- Verified: zero `<meta property="og:*">` tags across all audited pages.
- Result: shares on Facebook, LinkedIn, iMessage, Slack, Twitter/X show plain link with no preview image or polished title.
- Critical for social distribution and modern AI crawlers (some use OG tags for page summaries).
- Yoast/RankMath plugin handles this automatically. Or a custom `wp_head` hook.

### 6. No structured data (JSON-LD)
- Zero `<script type="application/ld+json">` blocks anywhere.
- **Highest-impact opportunity for this business:** the Amity and McMinnville locations should each have **`LocalBusiness`** schema (or `Bakery` / `Restaurant` subtypes) with name, address, geo coordinates, opening hours, telephone, photo. This is what powers Google Maps "Knowledge Panel" results and is heavily used by ChatGPT/Perplexity for local queries like "where can I buy pies near me in McMinnville."
- Also recommend:
  - `Organization` schema on the homepage (with `logo`, `sameAs` to social profiles).
  - `Recipe` schema for any pie recipe content (if added).
  - `WebSite` schema with `potentialAction` for a future search.
- Implementation: hard-code into a theme template part, or use a schema plugin (Schema Pro, RankMath has it built in).

## Warnings (fix this month)

### 7. Images missing `width` / `height` attributes — CLS risk
- Most `<img>` tags lack explicit `width`/`height`. This causes layout shift as images load → bad CLS score → ranking impact.
- Add explicit dimensions to all images. WordPress can do this automatically via `wp_filter_content_tags` if the attachments have metadata.

### 8. No image format modernization
- All 12 homepage images are `.jpg` or `.png`. No WebP or AVIF.
- WebP saves ~30% file size vs JPEG. AVIF saves ~50% with equivalent quality.
- Options:
  - WPEngine has built-in image optimization (verify it's enabled in dashboard).
  - Use a plugin like ShortPixel, Smush, or EWWW.
  - Generate WebP variants and use `<picture>` element manually.

### 9. Empty blog description / tagline
- `wp option get blogdescription` returns empty string.
- WordPress uses this as the default in some meta contexts. Set a brand-appropriate tagline:
  ```
  wp @local option update blogdescription "Handcrafted pies from our farm to your table since 1928"
  ```

### 10. Security headers — likely missing on prod
- Can't fully verify due to basic auth, but local server doesn't set:
  - `Strict-Transport-Security`
  - `X-Content-Type-Options: nosniff`
  - `X-Frame-Options`
  - `Content-Security-Policy`
  - `Referrer-Policy`
- WPEngine + Cloudflare typically handle some (especially HSTS via Cloudflare). Verify in production once auth is off.
- Configure via Cloudflare dashboard → Security → HTTP Headers or via WPEngine settings.

### 11. `X-Powered-By: PHP/8.3.30` exposed
- Minor info disclosure. Best practice: hide PHP version via `expose_php = Off` in php.ini (WPEngine controls this).

## Recommendations (optimize this quarter)

### 12. IndexNow protocol for faster Bing/ChatGPT indexing
- Bing supports IndexNow for near-instant indexing notifications.
- ChatGPT web search and Bing Copilot both use Bing's index.
- Install the "IndexNow" plugin or built-in support (RankMath has it).
- Faster Bing indexing = faster AI visibility on two major platforms.

### 13. Add `sameAs` links in Organization schema
- Once Organization schema is added, include `sameAs` pointing to Facebook, Instagram, etc. — helps AI systems triangulate the entity.

### 14. Consider a `/blog/` for content marketing
- Recipe posts, baking tips, seasonal updates would give Google and AI more content to cite. Each post = another doorway for queries.
- Particularly valuable for "how to bake a frozen pie" / "best blueberry pie recipe" style queries that AI systems frequently answer.

### 15. Consider canonical hostname enforcement
- Verify on prod (once auth removed): does `http://blueraevenfarms.com/` redirect to `https://blueraevenfarms.com/`? And does `https://www.blueraevenfarms.com/` redirect to the non-www version (or vice versa)? Cloudflare typically handles both.

### 16. Consider redirecting old blueraevenfarmstand.com domain
- You've already built legacy URL redirects (`/about/` → `/story/`, etc.) in `functions.php`. **Confirm the old domain `blueraevenfarmstand.com` is set up to redirect (301) to `blueraevenfarms.com` at the DNS/server level.** Without that step, the in-app redirects can't fire because traffic never reaches the new server.

### 17. Submit sitemap to Google Search Console + Bing Webmaster Tools
- Sitemap exists at `https://blueraevenfarms.com/wp-sitemap.xml`.
- Once auth is removed, verify the domain in GSC and Bing Webmaster, submit the sitemap.
- Monitor for crawl errors.

---

## Detailed Findings by Category

### Crawlability: 13/15

- ✅ `robots.txt` valid, allows everything except `/wp-admin/`, references sitemap.
- ✅ All major AI crawlers allowed (no specific blocks).
- ✅ XML sitemap at `/wp-sitemap.xml` (index format), with sub-sitemap for pages listing all 11 published pages.
- ✅ All key content reachable within 2 clicks from homepage.
- ⚠️ Crawl currently fully blocked by HTTP Basic Auth on prod (-15 if you score against reality).

### Indexability: 7/12

- ✅ Canonical tags present on every audited page, all self-referencing correctly.
- ✅ No duplicate content issues detected (single hostname, no parameter variants seen).
- ✅ No erroneous `noindex` directives.
- ⚠️ Index bloat: WordPress emits `feed/`, `comments/feed/`, `oembed`, `wp-json` discovery links in head — non-fatal but unnecessary surface area. Consider removing via `remove_action('wp_head', ...)` calls.
- ⚠️ www vs. non-www and HTTP vs. HTTPS canonicalization couldn't be verified through the auth wall.

### Security: 6/10

- ✅ HTTPS enforced (Cloudflare TLS).
- ✅ Cloudflare in front (DDoS protection, edge caching, HTTP/3).
- ⚠️ No visible HSTS / CSP / X-Frame / X-Content-Type-Options headers from local dev server. Likely set by Cloudflare on prod but can't verify through auth wall.
- ⚠️ `X-Powered-By: PHP/8.3.30` minor info disclosure.

### URL Structure: 8/8

- ✅ Clean, readable URLs (`/story/`, `/farmstand/`, `/pies-more/pies/`).
- ✅ Logical hierarchy (sub-pages nested under `/pies-more/` and `/story/`).
- ✅ Legacy URL redirects implemented in `functions.php` (`/about/` → `/story/`, `/contact.html` → `/contact/`, `/shop/*` → `/pies-more/pies/`, etc.).
- ✅ No URL parameters generating duplicate content.

### Mobile Optimization: 10/10

- ✅ `<meta name="viewport" content="width=device-width, initial-scale=1">` present.
- ✅ Responsive design with breakpoints at 900px, 640px, etc.
- ✅ Tap targets generally appropriate size.
- ✅ Mobile nav implemented as full-screen drawer with proper touch behavior.

### Core Web Vitals: 7/15 (estimated, no field data)

- ⚠️ **LCP**: hero has heavy video carousel + large pie-fixes-everything PNG. Estimated 3-4s on mid-tier devices. Optimize hero video preload + image format.
- ✓ **INP**: SSR + small inline scripts (carousel, gallery rotation, form submit). Should be well under 200ms.
- ✗ **CLS**: high risk. Images lack explicit width/height attributes throughout. Will shift visibly as they load.

### Server-Side Rendering: 15/15

- ✅ Full WordPress PHP rendering. **All content present in raw HTML.**
- ✅ Headings, body text, meta tags, canonical, alt text — everything in the initial response.
- ✅ Internal links server-rendered.
- ✅ Best-possible category score. AI crawlers (GPTBot, PerplexityBot, ClaudeBot) will get full content.

### Page Speed & Server: 10/15

- ✅ TTFB locally 112ms (excellent — well below 800ms target).
- ✅ HTML weight 48KB (homepage).
- ✅ Cloudflare CDN in front of WPEngine.
- ✅ Most images already optimized for web (size reduced).
- ⚠️ No WebP/AVIF — all JPG/PNG. ~30-50% size opportunity.
- ⚠️ Many images lack explicit dimensions (also a CLS issue).
- ⚠️ No `<link rel="preload">` for above-fold hero assets.

---

## Quick-Win Action Plan (in order of impact, lowest effort)

1. **Remove production HTTP Basic Auth** *(WPEngine dashboard, 1 minute)* — unblocks everything below.
2. **Update WP site name + tagline** *(2 minutes via wp-cli)*:
   ```bash
   wp @local option update blogname "Blue Raeven Farms"
   wp @local option update blogdescription "Handcrafted pies from our farm to your table"
   ```
3. **Add Yoast SEO or RankMath plugin** *(~15 min setup + per-page editing)* — gets you meta descriptions, OG tags, Twitter cards, sitemap improvements, and breadcrumbs in one move.
4. **Add LocalBusiness schema** for both Amity and McMinnville locations *(theme template work, ~1 hour)* — single biggest GEO win for a local food business.
5. **Add `<h1>` to homepage** *(~5 min, theme template edit)*.
6. **Add width/height to images** *(~30 min, sweep through theme + page content)*.
7. **Confirm `blueraevenfarmstand.com` DNS redirects to `blueraevenfarms.com`** *(15 min DNS work)*.
8. **Submit sitemap to GSC + Bing Webmaster Tools** *(15 min once auth is off)*.

Total effort for #1-#8: roughly a half-day of focused work, and it'd move the score from ~67 to ~90+.
