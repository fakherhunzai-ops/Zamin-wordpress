# Zamin Real Estate — WordPress theme

An installable WordPress theme that recreates [zaminzameen.com](https://zaminzameen.com/) as a fully editable WordPress site. No paid plugins or page builders are required.

The repository contains one theme: [`zamin/`](zamin). It mirrors the live site's copy, images, page structure and empty listing state (no properties or stays are published by default, exactly as on the live site).

A ready-to-upload archive is provided as [`zamin.zip`](zamin.zip). It contains a single top-level `zamin/` directory with `style.css` and `functions.php` directly inside, so it can be uploaded straight to WordPress without the "missing style.css stylesheet" error.

## Install

1. Download [`zamin.zip`](zamin.zip) and upload it through **Appearance → Themes → Add New → Upload Theme**, or copy the `zamin/` folder into `wp-content/themes/zamin/`.
2. Activate **Zamin Real Estate**.
3. On activation the theme automatically:
   - creates every page from the live site and sets the homepage;
   - creates the primary and footer menus;
   - seeds locations, property types, stay destinations, stay areas and stay types;
   - switches to `/%postname%/` permalinks so URLs match the live site.
4. Open **Appearance → Zamin Settings** to update the phone number, email, WhatsApp number, office address and form notification recipient.

If pages or menus are deleted later, **Appearance → Zamin Settings → Create / restore pages and menus** recreates them.

Requires WordPress 6.x and PHP 7.4+ (tested with PHP 8.3).

## Pages created

| Page | URL | Content |
| --- | --- | --- |
| Home | `/` | Hero, search, stats, featured listings, stays, locations, services, advisors, testimonials, alerts |
| Properties for sale | `/properties-for-sale/` | Location / type / price / bedroom filters and sorting |
| Properties for rent | `/properties-for-rent/` | Same, filtered to rentals |
| Sell your property | `/sell-your-property/` | Five-step process, benefits and submission form |
| Valuation | `/valuation/` | Why value, statistics and valuation request form |
| Services | `/services/` | Seven service sections with anchors |
| Contact | `/contact/` | Contact details, map and enquiry form |
| Privacy | `/privacy/` | Full privacy policy |
| ZAMIN Stays | `/stays/` | Stay search, destinations, types, hosting models |
| Become a host | `/stays/host/` | Hosting models and onboarding steps |
| Host application | `/stays/host/apply/` | Full host application form |
| Managed hosting | `/stays/managed-hosting/` | Managed service details |
| Destination pages | `/stays/hunza/`, `/gojal/`, `/skardu/`, `/naltar/`, `/ghizer/` | Area filters and stay listings |

## Editing content

- **Properties → All Properties**: add listings. Set purpose, price, bedrooms, bathrooms, area, address, verified/featured flags and assign a location and property type. Add a featured image for the card.
- **Stays → All Stays**: add stays. Set nightly price, guests, beds, rooms, amenities, hosting model and verification; assign a destination, area and stay type.
- Listing cards appear automatically on the homepage, listing pages, destination pages and archives. Search filters and sorting work against these fields.
- Enquiries, valuations, property submissions, host applications, stay enquiries and viewing requests are saved under **Enquiries**. Alert signups are saved under **Property Alerts**. A notification email is sent to the configured address.
- Page copy is made of theme shortcodes, so sections can be reordered or removed from the WordPress page editor.

### Shortcodes

`[zamin_home]`, `[zamin_properties purpose="sale|rent"]`, `[zamin_sell]`, `[zamin_valuation]`, `[zamin_services_page]`, `[zamin_contact]`, `[zamin_privacy]`, `[zamin_stays_home]`, `[zamin_destination key="hunza"]`, `[zamin_host]`, `[zamin_managed]`, `[zamin_host_apply]`, `[zamin_form type="contact|valuation|sell|alert|host_apply|booking|viewing|stay_match"]`, `[zamin_alert_band]`, `[zamin_consult_band]`.

## Interactive features

- Property search: purpose, location, type, price band and minimum bedrooms.
- Stay search: destination, area, dates, guests and stay type.
- Sorting: featured, newest, price ascending/descending.
- AJAX forms with validation, nonce checks, honeypot spam protection, up to five uploaded images (JPG/PNG/WEBP) and email notifications.
- Saved listings and recent searches are stored in the visitor's browser, matching the source site's privacy policy.

## Images

The source site serves its editorial photography from `readdy.ai`. The theme references the same image URLs through `zamin_image()` in [`zamin/inc/helpers.php`](zamin/inc/helpers.php), so replace those URLs with locally hosted media if you prefer. Cards fall back to a branded image when a listing has no featured image.

## Theme structure

```
zamin/
├── style.css                 Design system and all component styles
├── functions.php             Bootstrap
├── header.php / footer.php   Shared layout
├── front-page.php, page.php, single.php, index.php, search.php, 404.php
├── single-zamin_property.php, single-zamin_stay.php
├── archive-zamin_property.php, archive-zamin_stay.php
├── inc/
│   ├── helpers.php           Settings, images, links, menu fallbacks
│   ├── post-types.php        CPTs, taxonomies, admin columns
│   ├── meta-boxes.php        Editable listing fields
│   ├── forms.php             Form definitions, rendering, AJAX handling
│   ├── content.php           All page sections and shortcodes
│   └── activation.php        Page/menu/term setup and settings screen
└── assets/js/theme.js        Navigation, filters, forms, saved listings
```

## Validation

All PHP files were syntax-checked, and the theme was booted in WordPress 6.x / PHP 8.3 (Playground). Every page returned HTTP 200, forms submitted and saved correctly, and property/stay filters, single listing pages and archives were exercised with temporary listings.
