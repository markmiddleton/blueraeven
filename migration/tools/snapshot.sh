#!/usr/bin/env bash
# Golden snapshots: capture every page's rendered HTML (full + <main> region).
# These files are the immutable reference for all migration comparisons.
# Re-run ONLY under the drift protocol (content change applied to original page,
# logged in MIGRATION-TRACKER.md).
set -euo pipefail

BASE="https://local.blueraevenfarms.com"
DIR="$(cd "$(dirname "$0")/.." && pwd)/golden"
mkdir -p "$DIR"

PAGES="
home /
story /story/
our-berries /story/our-berries/
new-brand-look /story/new-brand-look/
farmstand /farmstand/
contact /contact/
pies /pies-more/pies/
jams-spreads /pies-more/jams-spreads/
other-confections /pies-more/other-confections/
baking-instructions-faqs /pies-more/baking-instructions-faqs/
wholesale-fundraising /wholesale-fundraising/
"

echo "$PAGES" | while read -r slug path; do
  [ -z "$slug" ] && continue
  url="$BASE$path"
  full="$DIR/$slug.html"
  main="$DIR/$slug.main.html"
  curl -sk "$url" > "$full"
  # main content region (single <main> per page in this theme)
  awk '/<main/{f=1} f{print} /<\/main>/{f=0}' "$full" > "$main"
  printf "%-28s %8d bytes (main: %d)\n" "$slug" "$(wc -c < "$full")" "$(wc -c < "$main")"
done

echo ""
echo "Snapshots written to $DIR — $(date)"
