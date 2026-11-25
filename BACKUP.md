# WordPress migration backup

`zamin-wordpress.wpress` is a complete All-in-One WP Migration (free, v4.4) backup of a clean WordPress 7.1.5 installation with the `zamin` theme from `main` activated.

## What's inside

- All of `wp-content`: the `zamin` theme, media/uploads, default themes and plugin files (the migration plugin itself is excluded by the plugin, as usual).
- A MySQL-compatible `database.sql` with all 12 WordPress tables, including the 17 pages created by the theme, menus, options, taxonomy terms and theme settings.
- `package.json` with the original site URL and WordPress version, so the importer can replace URLs with your site's URL on restore.

## Configuration captured

- Theme: Zamin Real Estate (`zamin`), active as `stylesheet`.
- Permalinks: `/%postname%/` (Post name).
- All-in-One WP Migration: 4.4, active.
- Site title: Zamin Real Estate Gilgit-Baltistan.
- Listings: none published, matching the live site's empty state.

## Import

1. Install and activate the free **All-in-One WP Migration** plugin on your WordPress site.
2. Go to **All-in-One WP Migration → Import → Import From File**.
3. Choose `zamin-wordpress.wpress` and confirm the overwrite prompt.
4. After the import finishes, log back in (the admin user is replaced by the one in this backup) and go to **Settings → Permalinks → Post name**, then save to flush rewrite rules.

The importer automatically replaces the backup's site URL (`https://9400-i8l5dv1wtj25l0mpmnjxy.e2b.app`) with your site's URL.

## Verification

SHA-256:

```
2519cf12d44daf6ecfc058421ab0993065b28e795a0e6007e3bb56195e86e8a3  zamin-wordpress.wpress
```

The archive was parsed after export: 1,703 file entries, a valid EOF block, `package.json`/`database.sql` at the root, 14 theme files, and 12 `CREATE TABLE` statements.

Note: the sandbox runs WordPress through SQLite, so the plugin's built-in MySQL dumper cannot run there. The SQL dump was generated from the live WordPress database with the standard `wp_get_db_schema()` schema and MySQL-compatible `INSERT` statements, then packaged by the plugin's own archiver. The resulting `.wpress` uses the plugin's native archive format.

Supabase was not used; it remains turned off in this conversation.
