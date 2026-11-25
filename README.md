# WordPress starter for local business sites

Every client site starts as a copy of this repo: a block theme (`themes/starter`)
and a small site plugin (`plugins/starter-core`). See the project's Playbook and
Technical standards for the overall workflow.

| Path | What |
| --- | --- |
| `themes/starter/` | Block theme: `theme.json` design system, templates, parts, section patterns, Inter font, Finnish translation |
| `plugins/starter-core/` | Settings → Business details, block bindings, opening-hours and contact-form blocks, SEO fields, LocalBusiness data, preview notice, emoji removal, WebP uploads |
| `bin/new-client.sh` | Copies and renames both for a new client |

Requires WordPress 6.8+ and PHP 7.4+. No third-party plugins.

## Working on the starter itself

The Local site **starter** loads this repo through two symlinks:

```bash
cd ~/Local\ Sites/starter/app/public/wp-content
ln -s ~/Downloads/projects/wp-starter/themes/starter themes/starter
ln -s ~/Downloads/projects/wp-starter/plugins/starter-core plugins/starter-core
```

The theme has no build step. The plugin's blocks and editor panel do:

```bash
cd plugins/starter-core
npm ci
npm run build     # or: npm run start while developing the blocks
```

`build/` is committed, so a server never needs Node. If a PHP change doesn't
show on Local, restart the site in Local.

## A new client

### 1. Copy and rename

Run the script from this repo. The target is where the new client repo will
live; use a full path so it never ends up inside the starter. The script
creates the folder if needed.

```bash
cd ~/Downloads/projects/wp-starter
bin/new-client.sh kahvila-aalto "Kahvila Aalto" ~/Downloads/projects/kahvila-aalto
```

Then build the plugin and start the client's git repo:

```bash
cd ~/Downloads/projects/kahvila-aalto/plugins/kahvila-aalto-core
npm ci
npm run build

cd ~/Downloads/projects/kahvila-aalto
git init
```

The script creates `themes/<slug>`, `plugins/<slug>-core`, `docs/` and a
`CLIENT.md` stub, and renames:

| In the starter | Becomes (slug `kahvila-aalto`) |
| --- | --- |
| Theme Name `Starter`, Plugin Name `Starter Core` | `Kahvila Aalto`, `Kahvila Aalto Core` |
| Text domains `starter`, `starter-core` | `kahvila-aalto`, `kahvila-aalto-core` |
| Functions `starter_…`, `starter_core_…` | `kahvila_aalto_…`, `kahvila_aalto_core_…` |
| Constants `STARTER_…` (incl. `STARTER_PREVIEW`) | `KAHVILA_AALTO_…` |
| Block, pattern and bindings namespace `starter/…` | `kahvila-aalto/…` |
| Option `starter_core_business`, meta `_starter_seo_title`/`_description` | `kahvila_aalto_core_business`, `_kahvila_aalto_seo_…` |
| Slugs and classes `starter-…` (pattern category, image size, CSS) | `kahvila-aalto-…` |
| JS global `starterCoreL10n` | `kahvilaAaltoCoreL10n` |
| `starter-core.php`, `languages/starter-core-fi.l10n.php` | `kahvila-aalto-core.php`, `…/kahvila-aalto-core-fi.l10n.php` |

It lists any remaining "starter" mentions at the end; only the theme
description and two doc comments should be left, for you to rewrite.

### 2. Local site

Create a Local site named after the client (here `kahvila-aalto`), then link
the theme and plugin from the client repo into its `wp-content`, the same way
the starter is linked. The folder under `~/Local Sites/` is the Local site's
name:

```bash
cd ~/Local\ Sites/kahvila-aalto/app/public/wp-content
ln -s ~/Downloads/projects/kahvila-aalto/themes/kahvila-aalto themes/kahvila-aalto
ln -s ~/Downloads/projects/kahvila-aalto/plugins/kahvila-aalto-core plugins/kahvila-aalto-core
```

Then, in WordPress:

1. Activate the theme and the plugin.
2. **Asetukset → Yleinen**: Sivuston kieli Suomi, Päivämäärän oletusmuoto `j.n.Y`, Kellonajan oletusmuoto `H.i`.
3. **Asetukset → Osoiterakenne**: match the old site's URLs where possible.
4. **Asetukset → Yrityksen tiedot**: name, type, address, phone, email, opening hours. These fill the footer, the contact and location sections, the opening-hours blocks and the structured data.
5. **Asetukset → Tietosuoja**: publish the privacy notice page; the footer and the contact form link to it.
6. **Artikkelit → Kategoriat**: rename the default category "Uncategorized".
7. Pages built from sections use the **Täysleveät osiot** template and start with the Hero or Sivun otsikko pattern (one h1 each).

### 3. Design

- **Colours**: change the hex values in `theme.json` → `settings.color.palette`. Slugs are roles (`base`, `contrast`, `primary`, `accent`…), so patterns keep working. Check contrast (4.5:1 for text, 3:1 for `border`).
- **Fonts**: put the woff2 files in `assets/fonts/<family>/` with their licence, then update `fontFamilies` (`body`, `heading`). At most two families, only the weights used.
- **Logo**: **Ulkoasu → Editori**, header → the Sivuston logo block.
- **Menu**: core Navigaatio block, edited in **Ulkoasu → Editori**. It turns into the hamburger menu below 64rem; change that breakpoint in `style.css` if the menu is much shorter or longer.

## Preview on Hostinger

On a Hostinger temporary address (`*.hostingersite.com`, `*.hostinger-site.com`,
`*.builder-preview.com`, `*.preview-domain.com`) the plugin automatically shows
the "Esikatselu / Preview" bar and sends `noindex` (robots meta, `X-Robots-Tag`,
`robots.txt`). Still tick **Asetukset → Lukeminen → "Kiellä sivuston näkyminen hakukoneissa"** as well.

To force it either way, add to `wp-config.php`:

```php
define( 'STARTER_PREVIEW', true );  // or false; renamed per client
```

## Notes

- **Contact form**: posts to its own page; nonce, honeypot and a limit of 5 messages per 10 minutes per visitor. Messages are only emailed (to the form address in Business details), never stored. The page with the form is kept out of Hostinger's page cache so the nonce never goes stale. Test delivery to the owner's inbox before launch; Local catches mail in its own mail viewer.
- **SEO**: the "Hakukoneet" panel in the editor sidebar sets the title and description per page. If a dedicated SEO plugin (Yoast, Rank Math, AIOSEO, The SEO Framework, SEOPress, Slim SEO) is active, the panel and all SEO output switch off. LocalBusiness data stays, on the front page only.
- **Bindings** (`starter/business`): `name`, `address`, `address_line`, `phone`, `phone_link`, `email`, `email_link`, `map_url`, `copyright`, `privacy_link`. A bound paragraph or button with an empty value is removed from the page.
- **Translations**: `themes/starter/languages/fi.l10n.php` and `plugins/starter-core/languages/starter-core-fi.l10n.php` are plain PHP arrays that WordPress reads directly. Add new strings there. The editor scripts get their strings from PHP (`includes/blocks.php`), so no JSON translation files are needed.
- **Images**: JPEG and PNG uploads are saved as WebP when the server supports it.
