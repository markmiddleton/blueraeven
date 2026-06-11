# Migration Tracker

Gates: **DOM** = compare.php DOM-equivalence vs golden · **Visual** = pixel/eyeball check · **JS** = behavior check (where applicable).
A row is ✅ only when DOM + Visual pass (and JS where applicable). See MIGRATION-PLAN.md.

## Components — ALL BUILT (21)

| Component | Used on |
|---|---|
| br/story-banner | home ×2 (pilot) |
| br/page-hero | story, our-berries, farmstand, contact, pies, jams, confections, baking, wholesale |
| br/photo-banner | story, contact |
| br/hero-carousel | home |
| br/pie-feature | home ×2 |
| br/story-block | story ×2 (normal + reverse) |
| br/timeline | story |
| br/gallery-mosaic | story, farmstand |
| br/feature-links | story |
| br/testimonial | story |
| br/photo-collage | farmstand |
| br/retailer-section | farmstand |
| br/info-cards | farmstand |
| br/find-cards | farmstand |
| br/directions-split | farmstand |
| br/contact-methods | contact |
| br/contact-form | contact |
| br/faq-section | contact |
| br/social-cta | contact |
| br/pie-hero-split | pies |
| br/pie-card-list | pies |
| br/preorder-section | pies |
| br/instructions-faqs | baking |
| br/download-grid | wholesale |
| br/content-blocks | our-berries |
| br/product-list | jams-spreads |
| br/category-list | other-confections |

## Page-level DOM gates (full entry-content vs golden)

| Page | Rebuild URL | Rows | DOM | Visual | JS | Notes |
|---|---|---|---|---|---|---|
| home | /home-rebuild/ | 5 | ✅ | ⬜ | ⬜ | gated under front-page.html via temporary front-page swap |
| story | /story-rebuild/ | 8 | ✅ | ✅* | ⬜ | page-story template via meta; *Mark eyeballed pre-S7/S8 |
| our-berries | /our-berries-rebuild/ | 2 | ✅ | ✅ | n/a | Mark verified |
| farmstand | /farmstand-rebuild/ | 7 | ✅ | ⬜ | ⬜ | page-visit template via meta |
| contact | /contact-rebuild/ | 6 | ✅ | ⬜ | ⬜ | page-contact template via meta; form/captcha JS check pending |
| pies | /pies-rebuild/ | 4 | ✅ | ⬜ | n/a | 14 pie cards |
| jams-spreads | /jams-spreads-rebuild/ | 2 | ✅ | ✅ | n/a | Mark verified |
| other-confections | /other-confections-rebuild/ | 2 | ✅ | ✅ | n/a | Mark verified |
| baking | /baking-rebuild/ | 3 | ✅ | ✅ | ⬜ | Mark verified visually; FAQ toggle JS pending |
| wholesale | /wholesale-rebuild/ | 4 | ✅ | ⬜ | n/a | native blocks copied verbatim; only 2 raw-HTML islands converted |

## Remaining JS behavior checks (Phase 4)

- [ ] home: carousel advances every 12s, indicators clickable, video restarts on activation
- [ ] story + farmstand: mosaic crossfades every 3.5s, no duplicate tiles, full pool cycles
- [ ] contact: form submits via Web3Forms, hCaptcha validates, inline thank-you replaces form
- [ ] contact + baking: FAQ items toggle (theme.js)

## Remaining phases

- Phase 4: visual pass on home/farmstand/contact/pies/wholesale + JS checklist above
- Phase 5: editor polish + EDITOR-GUIDE.md + client walkthrough
- Phase 6: cutover (approval gate — content-replacement on original pages, final same-URL diff, then Mark pushes/copies)

## Log

- 2026-06-10 — Pilot passed. Hidden home backup block removed pre-snapshot (approved). Mark verified rebuild UX.
- 2026-06-10 — our-berries, jams, confections, baking pages DOM-green; Mark verified visually.
- 2026-06-10 — story (8 rows incl. timeline + mosaic JS), farmstand (7 rows), contact (6 rows incl. form JS), pies (14-card list), wholesale (native-block hybrid), home (carousel) all DOM-green. **All 10 pages pass full page-level gates.**
- Gotchas log: see migration/PILOT-NOTES.md (+ wp_kses style-attr rewrite → verbatim intro field on retailer-section; --skip-copy path prefix normalization ×59 + per-import fix thereafter).
- Mark's test story-banner row on home-rebuild was replaced during final assembly (as agreed).
- Drift protocol: no content changes to original pages without re-snapshot + log entry here.
- 2026-06-11 — Header + footer made editable via ACF options (Theme Settings); floating badge added. All gated IDENTICAL.
- 2026-06-11 — PROD→LOCAL reconciliation. Read-only audit found prod had diverged (client edits after the migration DB upload). Pulled into local to make it a complete superset before any future copy-up:
  - Page 350 "New Brand Look" (client-built with our page-hero + content-blocks) recreated locally (local id 345, parent Our Story). Images BLUERAEVEN_LOGO_NEW-1.png + Mini-3D-Box_web.png streamed from prod over SSH (scp blocked), imported (local ids 343/344), and remapped in the block content (prod 357→343, 354→344).
  - Page 49 (Pies) Pre-Order edits (added "Dungeness Crab Pot Pie"; "Beef Pot Pie"→"Smoked Brisket") pulled verbatim from prod; re-snapshotted golden.
  - Benign/no-action: page 3 (privacy draft, env-URL only), page 6 (redirected, content moot), products (8, all same; CPT unused in current design), key options (match).
  - Floating badge link /story/new-brand-look now resolves locally (200).
  - Net: local = prod content + new nav/footer/badge features. A future local→prod DB copy is now safe (superset; nothing prod-only would be lost). Backup: migration/backups/pre-reconcile-2026-06-11.sql.
