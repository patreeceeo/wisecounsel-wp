# wisecounsel-wp

Themes for **wisecounselwnc.org** — Wise Counsel, the counseling practice of
Janet Canfield in Asheville, NC.

This repo contains only `wp-content/themes`. It is synced to the live site by the
**WordPress Developer GitHub** plugin, so a push to the tracked branch deploys.
There is no build step.

## Layout

| Path | |
|---|---|
| `tpa-base/` | Parent theme — TPA Base, by Greater Heights Technology. Pure templates + ACF + vanilla JS, no page builder. Shared across TPA client sites; keep client-specific work out of it. |
| `tpa-janetcanfield/` | Active child theme. Client-specific templates, brand CSS, ACF field groups, and self-hosted fonts. |
| `index.php` | Silence-is-golden stub. |

Hosting is WordPress.com Atomic (per response headers: `host-header: WordPress.com`,
`x-ac: _atomic_bur`). Over SFTP the web root is `htdocs/`.

## Line endings

`.gitattributes` sets `* text=auto eol=lf`. The repo is LF throughout.

This exists because a Windows tool once rewrote the whole working tree to CRLF and
produced a spurious 11,607-line diff across 67 files, which buried a real 74-line
change. If you ever see a diff where insertions exactly equal deletions across
most of the repo, that's this — not your edit. Fix with:

```sh
git add --renormalize .
```

Working files may sit on disk as CRLF; git normalises on the way into the index,
so they still read as clean.

## robots.txt and AI crawlers

**robots.txt is virtual.** There is no file on disk. WordPress assembles it per
request through the `robots_txt` filter, with blocks contributed by Yoast, WPForms,
and a plugin that emits an AI-crawler blocklist. Do not upload a static
`robots.txt` to the web root — it shadows the dynamic one permanently, freezing
Yoast's `Sitemap:` line and WPForms' upload exclusion at whatever they were the
day you uploaded it.

Policy: **block crawlers that harvest for model training; allow the ones that
fetch at answer time**, because those are what cite and link back.

`tpa-janetcanfield/functions.php` carries a `robots_txt` filter (priority 99, so it
sees the fully assembled output) that removes two tokens the upstream plugin blocks:

- **`Google-Extended`** — does *not* affect AI Overviews or AI Mode. Those are
  Search, served from the Googlebot index; per Google's crawler docs,
  "Google-Extended does not impact a site's inclusion in Google Search nor is it
  used as a ranking signal in Google Search." It gates Gemini Apps / Vertex AI
  grounding, so blocking it only cost Gemini citations. Tradeoff accepted: content
  may also train future Gemini models.
- **`PerplexityBot`** — Perplexity's search-index bot, per their docs "not used to
  crawl content for AI foundation models." Blocking it was lost referrals for no
  training benefit.

Two traps worth remembering:

1. **Training and retrieval are separate product tokens for the same vendor.**
   `GPTBot` ≠ `OAI-SearchBot`, `ClaudeBot` ≠ `Claude-SearchBot`. Matching is on the
   exact token, so blocking one never blocks the other.
2. **Don't add `Allow:` groups for the retrieval bots.** A named group makes that
   bot obey only that group and ignore `User-agent: *` entirely, silently dropping
   the wpforms and wpo exclusions for it. Absence already means allowed.

Still blocked, intentionally: `GPTBot`, `ClaudeBot`, `anthropic-ai`, `CCBot`,
`Bytespider`, `Amazonbot`, `FacebookBot`, `meta-externalagent`,
`Applebot-Extended`, `omgili`/`omgilibot`, `SentiBot`.

To change what's blocked, prefer the plugin's own setting if you can find it — the
filter is a post-hoc strip and is fighting a checkbox if one exists. After any
change, verify against the live output rather than the source:

```sh
curl -s https://wisecounselwnc.org/robots.txt
```

## Performance notes

Fonts are self-hosted in `tpa-janetcanfield/assets/fonts/` and declared inline in
`header.php`. **Deploying the theme without that directory silently reverts to
Google Fonts** — the `file_exists()` guard falls through to the CDN path. See the
critical-path audit in the Wise Counsel project for the full picture, including the
LiteSpeed CSS-async interaction that made the font stylesheet vanish entirely.
