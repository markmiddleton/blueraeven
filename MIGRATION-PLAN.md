# Blue Raeven Farms — Component Migration Plan

**Goal:** Rebuild every content row on the site as an admin-manageable component (editable by a non-technical human in wp-admin), with rendered output that is an **exact match** to the current live markup. Build on new pages; never modify the current pages until the final, approved cutover.

**Standing rule for this entire project: ZERO CHANGES TO PRODUCTION.** No `git push wpengine`, no DB copy-ups, no uploads syncs. All work happens on local. The only phase that touches production is Phase 6 (Cutover), which requires explicit approval and a written go signal.

---

## Guiding Principles

1. **Exactness is the product.** A component that renders "almost" the current markup is a failed component. Every row passes a diff gate before it's checked off.
2. **Golden snapshots first.** Before any build work, we freeze byte-exact snapshots of every page's rendered output. Those snapshots are the immutable reference for every comparison that follows.
3. **One pilot before mass production.** The entire pipeline (field design → render template → populate → diff → sign-off) is validated end-to-end on a single component before we build the other ~19.
4. **The final gate is content-replacement on the same URL.** Row-level and page-level diffs during the build phase are working gates. The airtight final test: replace the original page's content with the new block composition **on local**, then diff that same URL against its golden snapshot. Same page, same template, same slug, same theme — the only variable is the content. Diff must be zero (under the agreed normalization rules).

---

## Technology Choice: ACF Pro Blocks

**Recommendation: ACF Pro blocks with PHP render templates.** Rationale:

- ACF Pro is already a theme dependency; the theme already registers two ACF blocks (`product-card`, `product-grid`) — proven pattern in this codebase.
- PHP render templates give us **total control over output markup** — the block emits exactly what the template echoes, no wrapper divs, no editor cruft. This is what makes byte-exactness achievable.
- Field UI in the editor is mature, supports repeaters/galleries/clone fields, and is friendly to non-technical editors.
- Field group definitions stored as JSON in the theme (`acf-json/` directory) → version-controlled, deployable via git like everything else.

Native (block.json + JS) blocks were considered and rejected for this phase: they require a build toolchain, and the save/render model makes byte-exact legacy markup harder, not easier.

---

## Phase 0 — Foundations, Tooling, and Pilot

**Deliverable: a proven pipeline + one perfect component, before any mass work.**

### 0.1 Guardrails
- [ ] Create feature branch `component-migration` in the parent repo (wpengine deploys only happen from explicit `git push wpengine main`; working on a branch makes an accidental deploy structurally impossible).
- [ ] Local DB backup (`wp @local db export migration/backups/pre-migration-$(date).sql`).
- [ ] Confirm ACF Pro is installed AND active on local; confirm the license also covers production (blocks won't render on prod without it).
- [ ] Enable `acf-json` saving in the theme (`acf/settings/save_json` → `theme/acf-json/`) so field groups are version-controlled.

### 0.2 Golden snapshots
- [ ] Script: `migration/tools/snapshot.sh` — curls every page on local, saves full HTML to `migration/golden/<slug>.html`.
- [ ] Also extract and save just the main content region per page: `migration/golden/<slug>.main.html`.
- [ ] Commit snapshots to the branch. These are now the frozen reference.
- [ ] **Content freeze protocol:** if the client requests any copy change during migration, it must be (a) applied to the original page, (b) golden snapshot regenerated with a logged note, and (c) applied to the rebuild page if that row is already built. No silent drift.

### 0.3 Comparison tooling
- [ ] Build `migration/tools/compare.php` (PHP CLI, uses DOMDocument — no new dependencies):
  - Inputs: two HTML sources (file or URL) + optional CSS selector to scope the comparison (e.g., `section.story-banner`).
  - Three comparison modes, run in order:
    1. **`--mode=bytes`** — raw byte diff of the selected region. The strictest gate.
    2. **`--mode=dom`** — DOM-equivalence: parse both sides, decode HTML entities, normalize inter-tag whitespace, compare element tree + attributes + text content. Catches real differences while tolerating `&ndash;` vs `–` (see "The Entity Question" below).
    3. **Report:** unified diff output, exit code 0 = identical.
- [ ] Visual gate: screenshot tooling (browser at 1440px / 768px / 390px widths) for pixel-level comparison of each rebuilt row vs the original. (Browser MCP tools or manual side-by-side — decided at pilot.)
- [ ] Tracker: `MIGRATION-TRACKER.md` — one table row per site row: page | row | component | built | populated | bytes-diff | dom-diff | visual | JS check | signed off.

### 0.4 The Entity Question (needs decision — see Open Questions)
The current markup contains HTML entities typed literally into the source: `&ndash;`, `&rsquo;`, `&middot;`, `&amp;`, `&hellip;`. A non-technical admin editing a text field will type `–` and `'` as actual characters. Both render **identically in the browser**, but a raw byte diff sees them as different.

Two ways to define "exact":
- **(A) Byte-strict:** fields must store entities; templates echo them raw. Output is byte-identical, but admins editing later must type `&ndash;` — which conflicts with the "human who doesn't know HTML" goal.
- **(B) DOM-strict + pixel-strict (recommended):** populate fields with real characters; comparison gate = DOM-equivalence (entities decoded on both sides) + zero visual pixel difference + identical rendered text. Everything a visitor, browser, or search engine sees is identical; only the underlying byte encoding of certain punctuation differs.

The pilot runs both modes so we can see exactly what (B) tolerates before committing.

### 0.5 Pilot component: `br/story-banner`
Chosen because it's small, has clear fields (bg image, title, subhead, CTA label, CTA URL, `--open` variant toggle, spacer toggle), and appears twice on the home page.

- [ ] Build field group + render template.
- [ ] Create draft page `home-rebuild`, insert the block, populate with current content.
- [ ] Run all three gates against the golden snapshot's story-banner region.
- [ ] Iterate until passing. Document every gotcha discovered (whitespace, attribute order, ACF output filters, wpautop) in `migration/PILOT-NOTES.md` — these become the build rules for all other components.
- [ ] **Checkpoint with Mark before proceeding to mass build.**

### Known landmines the pilot must resolve
| Risk | Detail | Mitigation to validate |
|---|---|---|
| `wpautop` on WYSIWYG fields | ACF WYSIWYG output runs through filters that inject `<p>` tags — would corrupt markup | Use textarea/text fields + controlled `<br>` conversion where possible; disable `acf_the_content` filters where WYSIWYG is unavoidable |
| Block wrapper markup | WP/ACF may inject wrapper divs or `id` anchors | Register with minimal supports (`anchor: false`, `align: false`, etc.); verify template output is the entire output |
| Whitespace/indentation | Current rows have specific indentation in source | Render templates replicate indentation exactly; bytes gate verifies |
| Attribute order | `<img decoding="async" src=...>` vs `<img src=... decoding=...>` | Templates hand-write attributes in the current order; never rely on WP image functions for legacy rows |
| Front-page template wrapper | `home-rebuild` draft renders with `page.html`, not `front-page.html` — different `<main>` wrapper + WP layout CSS | Row-level diffs scope inside the wrapper; final gate (content-replacement on the real page) eliminates the variable entirely |

---

## Phase 1 — Verified Row Inventory (the master to-do list)

Verified against the local DB. **~46 rows across 10 pages.** Page 6 (`pies-more`) is excluded — it 301-redirects to `/pies-more/pies/`, its content is unreachable. Page 3 (Privacy Policy) contains zero raw HTML — it's already native blocks and admin-editable; verify and exclude.

### Home (page 4) — 7 rows
| # | Row | Component |
|---|---|---|
| H1 | Hero carousel (2 slides: pan image + video, brand graphic, indicators, inline JS) | `br/hero-carousel` |
| H2 | "Best Fruit" 50/50 row + CTA | `br/pie-feature` |
| H3 | "Ready for Your Table" 50/50 reversed + CTA | `br/pie-feature` |
| H4 | Hidden original story-banner backup (decision: keep or drop) | n/a |
| H5 | Spacer + Story banner `--open` ("Story Behind…") | `br/story-banner` |
| H6 | Spacer + Story banner `--open` ("Wholesale and Fundraising") | `br/story-banner` |

### Our Story (page 5) — 6 rows
| # | Row | Component |
|---|---|---|
| S1 | Page hero (navy) | `br/page-hero` |
| S2 | Photo banner (foggy field) | `br/photo-banner` |
| S3 | Story intro section (image + prose) | `br/story-block` |
| S4 | Timeline (6 entries, 2 images each, crop classes) | `br/timeline` |
| S5 | "Pies Fix Everything" section (wood bg) | `br/story-block` or variant |
| S6 | Gallery mosaic (5 tiles, 44-image pool, crossfade JS) | `br/gallery-mosaic` |

### Farmstand (page 7) — 7 rows
| # | Row | Component |
|---|---|---|
| F1 | Page hero (navy) | `br/page-hero` |
| F2 | Visit photo collage (visit_hero + 2 scenes) | `br/photo-collage` |
| F3 | Grocers section (header, intro w/ inline link, 8 retailer buttons, "Also at area farmstands" + 14 names) | `br/retailer-section` |
| F4 | Come Visit Us + info cards (Amity/McMinnville torn-paper cards) | `br/info-cards` |
| F5 | What You'll Find (3 find-cards) | `br/find-cards` |
| F6 | Directions split (map/text) | `br/directions-split` |
| F7 | Gallery mosaic (shared with Story) | `br/gallery-mosaic` |

### Contact (page 8) — 6 rows
| # | Row | Component |
|---|---|---|
| C1 | Page hero (navy) | `br/page-hero` |
| C2 | Photo banner (foggy field) | `br/photo-banner` |
| C3 | Contact methods (3 torn-paper cards: Visit/Call/Email) | `br/contact-methods` |
| C4 | Form section (Web3Forms + hCaptcha + thank-you + inline JS) | `br/contact-form` |
| C5 | FAQ section ("Common Questions") | `br/faq-list` |
| C6 | Follow Along / social section | `br/social-cta` |

### Pies (page 49) — 5 rows
| # | Row | Component |
|---|---|---|
| P1 | Page hero (wood) | `br/page-hero` |
| P2 | Pie-hero-split (image + navy text panel) | `br/pie-hero-split` |
| P3 | Pies listing (sign image + pie cards) | `br/pie-card-list` |
| P4 | "Available at Farmstand Only" section | `br/pie-card-list` (variant) |
| P5 | Pre-Order & Pick Up section | `br/rich-text-section` |

### Jams & Spreads (page 50) — 2 rows
| # | Row | Component |
|---|---|---|
| J1 | Page hero (wood) | `br/page-hero` |
| J2 | Content section (cream) | `br/rich-text-section` or bespoke |

### Other Confections (page 51) — 2 rows
| # | Row | Component |
|---|---|---|
| O1 | Page hero (wood) | `br/page-hero` |
| O2 | Confections list section | `br/rich-text-section` or bespoke |

### Baking Instructions & FAQs (page 52) — 3 rows
| # | Row | Component |
|---|---|---|
| B1 | Page hero (wood) | `br/page-hero` |
| B2 | Instruction cards x2 (frozen baking / fresh warming) | `br/instruction-cards` |
| B3 | FAQ list (~8 items) | `br/faq-list` |

### Wholesale & Fundraising (page 53) — 4 rows
| # | Row | Component |
|---|---|---|
| W1 | Page hero (wood) | `br/page-hero` |
| W2 | Wholesale section (tagline, columns, CTA — already partially native blocks) | `br/rich-text-section` + audit |
| W3 | Fundraising section (tagline, copy) | `br/rich-text-section` |
| W4 | Download grid (3 cards, file links, icon types) | `br/download-grid` |

### Our Berries (page 82) — 2 rows
| # | Row | Component |
|---|---|---|
| OB1 | Page hero (wood) | `br/page-hero` |
| OB2 | Content blocks (strawberries image + prose, centered variant) | `br/content-blocks` |

**Phase 1 deliverables:**
- [ ] Re-verify each row's exact boundaries against the golden snapshots (block-by-block extraction, saved to `migration/golden/rows/<page>-<row>.html`).
- [ ] Finalize the component dedupe map (current estimate: **~19 components covering ~46 rows**).
- [ ] Populate `MIGRATION-TRACKER.md` with every row.

---

## Phase 2 — Component Library Design

For each component, before building:
- [ ] **Field schema** — name, type, required, default, admin label + help text. Field types follow these rules:
  - Plain text → `text` field
  - Multi-line with `<br>` (addresses, hours) → `textarea`, template converts newlines to `<br>` exactly
  - Prose with inline links/bold → constrained WYSIWYG (basic toolbar) **with wpautop disabled**, or split fields, per pilot findings
  - Natural lists (retailers, FAQ items, slides, timeline entries, download cards, pie cards) → **repeater** fields so admins can add/remove/reorder
  - Image pools (gallery mosaic) → ACF **gallery** field
  - Variants (`--reverse`, `--open`, bg color, crop classes) → select/toggle fields
  - URLs (internal links) → text or link field
- [ ] **Render template** (`blocks/<component>.php`) — hand-written to reproduce the golden markup byte-for-byte (indentation, attribute order, entity strategy per the Phase 0 decision).
- [ ] **Registration** in `functions.php` (same `acf_register_block_type` pattern as existing product blocks), category `blue-raeven`, minimal supports.
- [ ] Images: see "Asset Strategy" below.

### Asset strategy (needs decision — see Open Questions)
Three classes of image/file currently in play:
1. **Media library images** (`/wp-content/uploads/2026/...` registered attachments) — ACF image fields work directly. URLs unchanged. ✅
2. **Uploads-dir files that are NOT attachments** (the 44 `story-grid/*.jpg` gallery images — written directly to disk, never registered) — run `wp media import <file> --skip-copy` to register them **in place**: same URLs, now selectable in the media library. Best of both.
3. **Theme-asset images** (`/wp-content/themes/.../assets/images/...` — aerial/horizon, pie-fixes-everything, farmtable, logos; plus `assets/downloads/*.pdf|xlsx`) — not in the media library at all. Options: (a) keep current URLs at migration (byte-exact) via URL-default fields, with media-library override available for future edits; (b) sideload into the media library now (URLs change → breaks byte-exactness). **Recommendation: (a)** for migration, migrate to media library opportunistically later.

### JS-bearing components
Hero carousel, gallery mosaic, contact form, FAQ accordions carry inline `<script>` blocks. For byte-exactness, the render templates embed the same scripts (with field values like slide duration / pool URLs / sitekey interpolated). Optional Phase 7 refactor moves them to `theme.js` — explicitly out of scope for the migration itself because it changes output.

---

## Phase 3 — Build & Verify Loop (per row)

The repeating heartbeat of the project. For each row in the tracker:

1. **Extract** the row's golden HTML from `migration/golden/rows/`.
2. **Build** the component (if not already built for an earlier row).
3. **Insert + populate** on the `<page>-rebuild` draft with the current content, character for character.
4. **Diff gate 1 — bytes:** `compare.php --mode=bytes` golden row vs rebuilt row.
5. **Diff gate 2 — DOM:** `compare.php --mode=dom` (this is the pass/fail gate if decision (B) is taken).
6. **Diff gate 3 — visual:** screenshot the row on both pages at 3 widths; pixel-compare.
7. **JS check** (where applicable): carousel advances/indicators work; gallery crossfades with no duplicate tiles; form submits + hCaptcha validates + thank-you appears; FAQ expands/collapses.
8. **Record results** in `MIGRATION-TRACKER.md`; a row is ✅ only when gates 2+3 pass (and 1, under decision (A)).
9. **Commit** per component (field group JSON + template + tracker update) on the migration branch.

Rule: **no two rows in flight at once.** Finish, verify, check off, move on. Accuracy over speed.

---

## Phase 4 — Page Assembly & Page-Level Verification

When all rows of a page are ✅:
- [ ] Assemble full `<page>-rebuild` draft in original row order.
- [ ] Full main-content diff vs golden (`compare.php` scoped to the content region).
- [ ] Full-page screenshots at 3 widths vs original — pixel compare.
- [ ] Full JS behavior pass on the assembled page.
- [ ] Editor-experience smoke test: open the rebuild page in wp-admin as an Editor-role user; every row's content must be visible and editable through fields (zero raw HTML required).
- [ ] Mark page ✅ in tracker.

Home page note: the rebuild draft renders under `page.html` rather than `front-page.html`. Row-level gates handle the build phase; the front-page wrapper variable disappears at the Phase 6 content-replacement gate.

---

## Phase 5 — Editor Experience Polish

- [ ] Field labels, instructions, and placeholder text written for a non-technical human.
- [ ] Block icons + descriptions in the inserter; all components under a "Blue Raeven" category.
- [ ] ACF block preview mode so editors see rendered rows, not field forms, while browsing.
- [ ] Decide template locks (can editors reorder/remove rows? add new ones?).
- [ ] Write `EDITOR-GUIDE.md`: one page per component — what it is, screenshot, what each field does, how to change an image, how to add a FAQ/retailer/slide.
- [ ] Walkthrough session with the client admin; capture friction; iterate.

---

## Phase 6 — Cutover (APPROVAL GATE — the only phase that touches production)

Pre-conditions: every page ✅ in tracker, client sign-off on rebuild drafts, content freeze in effect.

1. [ ] Fresh local DB backup + tag the repo (`pre-cutover`).
2. [ ] Re-run all golden diffs (catch drift since snapshots).
3. [ ] **On local:** replace each original page's `post_content` with its rebuild composition (preserves page IDs, slugs, menu references, front-page setting, parent/child URLs — and means meta descriptions, schema hooks, and redirects, which key off slugs, work unchanged).
4. [ ] **Final gate:** diff every original URL on local against its golden snapshot. Same URL, same template, same theme — content is the only variable. Must pass DOM + visual gates (and bytes under decision (A)).
5. [ ] Delete/trash the `-rebuild` drafts.
6. [ ] Merge `component-migration` → `main`.
7. [ ] **With explicit go-ahead:** push theme to wpengine; Mark copies DB up per the established workflow.
8. [ ] Post-cutover verification on production: spot-diff key pages vs golden, JS checks, schema validation, GSC monitoring for 48h.
9. **Rollback plan:** DB backup restore (content) + `git revert` (theme). Both rehearsed before cutover day.

---

## Phase 7 — Cleanup & Hardening (post-cutover, optional)

- [ ] Retire the now-redundant static pattern files (`patterns/*.php`) or rebuild them as block-composition starters.
- [ ] Consider moving inline JS to `theme.js` (now safe — output no longer needs to match a legacy snapshot).
- [ ] Consider migrating theme-asset images to the media library.
- [ ] Decide whether the Pies listing should become Products-CPT-driven (the CPT + product blocks already exist) — content-architecture upgrade, separate project.
- [ ] Final documentation pass.

---

## Effort Estimate (rough)

| Phase | Estimate |
|---|---|
| 0 — Foundations + pilot | 1–2 sessions |
| 1 — Inventory verification + row extraction | ~1 session |
| 2+3 — ~19 components, ~46 rows, build + verify | 6–8 sessions (3–4 components/session incl. verification) |
| 4 — Page assembly + verification | 1–2 sessions |
| 5 — Editor polish + guide | 1–2 sessions |
| 6 — Cutover | 1 session |
| **Total** | **~11–16 working sessions** |

---

## Decisions (locked 2026-06-10)

1. **Exactness standard: (B) DOM + pixel strict.** The rendered output (what a visitor/browser/crawler sees) must be exact; the underlying byte encoding of equivalent punctuation (entity vs literal character) may differ. Gates: DOM-equivalence diff + visual pixel diff + rendered-text equality.
2. **ACF Pro:** license provided by Mark. NOT previously installed locally (plugins dir had only akismet/hello — the theme's `function_exists()` guards were silently skipping ACF features). Install locally with license; license key lives in `wp-config.php` (gitignored) — **never committed to git**. Plugin code itself is committed (private repo, normal practice) so it deploys at cutover.
3. **Assets → media library.** Theme-asset images and download files are imported into the WP media library. This changes their URLs — accepted. Compare tooling maintains an **asset URL map** (old → new) and (a) normalizes mapped URLs during DOM diff, (b) verifies the file at the new URL is checksum-identical to the old one, (c) pixel diff confirms rendering. Existing non-attachment uploads (e.g. the 44 story-grid gallery images) are registered in place via `wp media import --skip-copy` — same URLs, now library-visible.
4. **Editor flexibility: yes.** Repeaters for all natural lists (retailers, farmstands, FAQ items, slides, timeline entries, pie cards, download cards, gallery pools).
5. **Hidden story-banner backup block: drop.** Client has approved the current design. Removed from the live local page before golden snapshots (display:none, so zero visual change).
6. **Pies listing: repeater** matching current markup. Products-CPT migration = separate future project.
7. **Cutover: confirmed.** Build `-rebuild` pages in parallel for apples-to-apples comparison → after everything passes, replace current pages' content with the validated versions → copy entire site up to WPEngine → client takes over editing.
8. **Inline JS:** embedded in render templates during migration (exact output); theme.js refactor deferred to Phase 7.
