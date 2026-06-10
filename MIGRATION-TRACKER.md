# Migration Tracker

Gates: **DOM** = compare.php DOM-equivalence vs golden · **Visual** = pixel/eyeball check · **JS** = behavior check (where applicable).
A row is ✅ only when DOM + Visual pass (and JS where applicable). See MIGRATION-PLAN.md.

## Components

| Component | Status | Notes |
|---|---|---|
| br/story-banner | ✅ built | Pilot. All gates green. |
| br/page-hero | ✅ built | navy + wood variants; 8 pages |
| br/photo-banner | ✅ built | story, contact |
| br/hero-carousel | ⬜ | home; slides repeater + inline JS |
| br/pie-feature | ⬜ | home ×2; 50/50 with reverse variant |
| br/story-block | ✅ built | story intro + pies-fix-everything |
| br/timeline | ✅ built | story; repeater w/ images + crop classes |
| br/gallery-mosaic | ✅ built | story + farmstand; gallery field + JS |
| br/photo-collage | ⬜ | farmstand visit photos |
| br/retailer-section | ⬜ | farmstand; grocer repeater + farmstand list |
| br/info-cards | ⬜ | farmstand; torn-paper location cards |
| br/find-cards | ⬜ | farmstand; 3-up image cards |
| br/directions-split | ⬜ | farmstand |
| br/contact-methods | ⬜ | contact; torn-paper cards |
| br/contact-form | ⬜ | contact; Web3Forms + hCaptcha + JS |
| br/faq-list | ⬜ | contact + baking |
| br/social-cta | ⬜ | contact |
| br/pie-hero-split | ⬜ | pies |
| br/pie-card-list | ⬜ | pies; sign + repeater cards |
| br/instruction-cards | ⬜ | baking |
| br/download-grid | ⬜ | wholesale |
| br/content-blocks | ✅ built | our-berries |

## Rows

| Page | Row | Component | Built | Populated | DOM | Visual | JS | ✅ |
|---|---|---|---|---|---|---|---|---|
| home | H1 hero carousel | br/hero-carousel | | | | | | |
| home | H2 best-fruit 50/50 | br/pie-feature | | | | | | |
| home | H3 ready-for-table 50/50 | br/pie-feature | | | | | | |
| home | H5 story banner (story) | br/story-banner | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| home | H6 story banner (wholesale) | br/story-banner | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| story | S1 page hero | br/page-hero | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S2 photo banner | br/photo-banner | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S3 story intro | br/story-block | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S4 timeline | br/timeline | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S5 pies-fix-everything | br/story-block | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S6 gallery mosaic | br/gallery-mosaic | ✅ | ✅ | ✅ | ⬜ | ⬜ | ⬜ |
| story | S7 feature links | br/feature-links | ✅ | ✅ | ✅ | ⬜ | n/a | ⬜ |
| story | S8 testimonial | br/testimonial | ✅ | ✅ | ✅ | ⬜ | n/a | ⬜ |
| our-berries | OB1 page hero | br/page-hero | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| our-berries | OB2 content blocks | br/content-blocks | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| farmstand | F1 page hero | br/page-hero | | | | | | |
| farmstand | F2 visit collage | br/photo-collage | | | | | | |
| farmstand | F3 grocers section | br/retailer-section | | | | | | |
| farmstand | F4 info cards | br/info-cards | | | | | | |
| farmstand | F5 what-youll-find | br/find-cards | | | | | | |
| farmstand | F6 directions | br/directions-split | | | | | | |
| farmstand | F7 gallery mosaic | br/gallery-mosaic | | | | | | |
| contact | C1 page hero | br/page-hero | | | | | | |
| contact | C2 photo banner | br/photo-banner | | | | | | |
| contact | C3 contact methods | br/contact-methods | | | | | | |
| contact | C4 form section | br/contact-form | | | | | | |
| contact | C5 FAQ | br/faq-list | | | | | | |
| contact | C6 follow along | br/social-cta | | | | | | |
| pies | P1 page hero | br/page-hero | | | | | | |
| pies | P2 pie-hero-split | br/pie-hero-split | | | | | | |
| pies | P3 pies listing | br/pie-card-list | | | | | | |
| pies | P4 farmstand-only | br/pie-card-list | | | | | | |
| pies | P5 pre-order | br/rich-text or bespoke | | | | | | |
| jams-spreads | J1 page hero | br/page-hero | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| jams-spreads | J2 content | br/product-list | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| other-confections | O1 page hero | br/page-hero | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| other-confections | O2 confections list | br/category-list | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| baking | B1 page hero | br/page-hero | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| baking | B2 instruction cards | br/instructions-faqs | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| baking | B3 FAQ | br/instructions-faqs | ✅ | ✅ | ✅ | ✅ | n/a | ✅ |
| wholesale | W1 page hero | br/page-hero | | | | | | |
| wholesale | W2 wholesale section | mixed native + bespoke | | | | | | |
| wholesale | W3 fundraising section | bespoke | | | | | | |
| wholesale | W4 download grid | br/download-grid | | | | | | |

## Log

- 2026-06-10 — Pilot passed (story-banner ×2 + spacers DOM-identical). Hidden home backup block removed pre-snapshot (approved). Mark verified rebuild page + editor UX, added a test row himself. Proceed approved.
- Drift protocol: no content changes to original pages without re-snapshot + log entry here.
