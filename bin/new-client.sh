#!/usr/bin/env bash
#
# Create a new client repo from the starter.
#
#   bin/new-client.sh <slug> "<Display Name>" <target-dir>
#   bin/new-client.sh kahvila-aalto "Kahvila Aalto" ~/Downloads/projects/kahvila-aalto
#
# Copies themes/starter and plugins/starter-core into the target as
# themes/<slug> and plugins/<slug>-core, then renames every slug, prefix,
# constant, text domain, block namespace and option name. Nothing in this
# starter repo is changed. Run `npm ci && npm run build` in the new plugin
# afterwards so the compiled editor scripts carry the new names.

set -euo pipefail

if [ "$#" -ne 3 ]; then
	echo "Usage: $0 <slug> \"<Display Name>\" <target-dir>" >&2
	exit 1
fi

SLUG="$1"
NAME="$2"
TARGET="$3"

if ! [[ "$SLUG" =~ ^[a-z][a-z0-9-]*[a-z0-9]$ ]]; then
	echo "Slug must be lowercase letters, digits and hyphens, e.g. kahvila-aalto." >&2
	exit 1
fi
if [ "$SLUG" = "starter" ]; then
	echo "Pick the client's own slug, not 'starter'." >&2
	exit 1
fi
if [ -e "$TARGET/themes/$SLUG" ] || [ -e "$TARGET/plugins/$SLUG-core" ]; then
	echo "$TARGET already contains themes/$SLUG or plugins/$SLUG-core; nothing copied." >&2
	exit 1
fi

HERE="$(cd "$(dirname "$0")/.." && pwd)"
PREFIX="${SLUG//-/_}"                                   # kahvila_aalto
CONST="$(printf '%s' "$PREFIX" | tr '[:lower:]' '[:upper:]')"   # KAHVILA_AALTO
CAMEL="$(printf '%s' "$SLUG" | perl -pe 's/-(.)/\u$1/g')"        # kahvilaAalto
PASCAL="$(printf '%s' "$CAMEL" | perl -pe 's/^(.)/\u$1/')"       # KahvilaAalto

mkdir -p "$TARGET/themes" "$TARGET/plugins" "$TARGET/docs"

# Copy without dependencies or OS noise.
copy_dir() {
	mkdir -p "$2"
	( cd "$1" && tar -cf - --exclude node_modules --exclude .DS_Store . ) | ( cd "$2" && tar -xf - )
}
copy_dir "$HERE/themes/starter" "$TARGET/themes/$SLUG"
copy_dir "$HERE/plugins/starter-core" "$TARGET/plugins/$SLUG-core"
[ -f "$TARGET/.gitignore" ] || cp "$HERE/.gitignore" "$TARGET/.gitignore"

mv "$TARGET/plugins/$SLUG-core/starter-core.php" "$TARGET/plugins/$SLUG-core/$SLUG-core.php"
mv "$TARGET/plugins/$SLUG-core/languages/starter-core-fi.l10n.php" "$TARGET/plugins/$SLUG-core/languages/$SLUG-core-fi.l10n.php"

# Rename in every text file. Order matters: the longest, most specific forms first.
export NAME CONST PREFIX SLUG CAMEL PASCAL
find "$TARGET/themes/$SLUG" "$TARGET/plugins/$SLUG-core" -type f \
	\( -name '*.php' -o -name '*.json' -o -name '*.html' -o -name '*.css' -o -name '*.js' -o -name '*.md' \) \
	-print0 | xargs -0 perl -pi -e '
		s/Theme Name: Starter\b/Theme Name: $ENV{NAME}/g;
		s/Plugin Name:(\s+)Starter Core\b/Plugin Name:$1$ENV{NAME} Core/g;
		s/\bStarter Core\b/$ENV{NAME} Core/g;
		s/\bStarterCore\b/$ENV{PASCAL}Core/g;
		s/\@package Starter\b/\@package $ENV{PASCAL}/g;
		s/\bstarterCore/$ENV{CAMEL}Core/g;
		s/\bSTARTER_/$ENV{CONST}_/g;
		s/\b_starter_/_$ENV{PREFIX}_/g;
		s/\bstarter_/$ENV{PREFIX}_/g;
		s/\bstarter-/$ENV{SLUG}-/g;
		s/\bstarter\//$ENV{SLUG}\//g;
		s/'"'"'starter'"'"'/'"'"'$ENV{SLUG}'"'"'/g;
		s/Text Domain: starter\b/Text Domain: $ENV{SLUG}/g;
	'

cat > "$TARGET/docs/README.md" <<EOF
# $NAME – docs

Discovery notes, the old site's URL list and the redirect map go here.
EOF

[ -f "$TARGET/CLIENT.md" ] || cat > "$TARGET/CLIENT.md" <<EOF
# $NAME

Copy the "Client brief template" from the project here and fill it in.
EOF

echo "Created $TARGET"
echo "  themes/$SLUG"
echo "  plugins/$SLUG-core"
echo
echo "Remaining mentions of 'starter' (review these by hand):"
grep -rn -i 'starter' "$TARGET/themes/$SLUG" "$TARGET/plugins/$SLUG-core" \
	--include='*.php' --include='*.json' --include='*.html' --include='*.css' --include='*.js' \
	| grep -v '/build/' || echo "  none"
echo
TARGET_ABS="$(cd "$TARGET" && pwd)"
cat <<NEXT
Next steps:

  1. Build the plugin and start the client's git repo:
       cd "$TARGET_ABS/plugins/$SLUG-core" && npm ci && npm run build
       cd "$TARGET_ABS" && git init

  2. Create a Local site named "$SLUG", then link the theme and plugin into it:
       cd ~/Local\\ Sites/$SLUG/app/public/wp-content
       ln -s "$TARGET_ABS/themes/$SLUG" themes/$SLUG
       ln -s "$TARGET_ABS/plugins/$SLUG-core" plugins/$SLUG-core

  3. Activate both in WordPress and follow README.md, "2. Local site".
NEXT
