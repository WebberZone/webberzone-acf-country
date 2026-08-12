# WebberZone ACF Country

[![License](https://img.shields.io/badge/license-GPL_v2%2B-orange.svg?style=flat-square)](https://opensource.org/licenses/GPL-2.0)
[![Coding Standards](https://img.shields.io/github/actions/workflow/status/WebberZone/webberzone-acf-country/cs.yml?branch=master&label=coding%20standards&style=flat-square)](https://github.com/WebberZone/webberzone-acf-country/actions/workflows/cs.yml)
[![Unit Tests](https://img.shields.io/github/actions/workflow/status/WebberZone/webberzone-acf-country/unit-tests.yml?branch=master&label=unit%20tests&style=flat-square)](https://github.com/WebberZone/webberzone-acf-country/actions/workflows/unit-tests.yml)
[![PHP Compatibility](https://img.shields.io/github/actions/workflow/status/WebberZone/webberzone-acf-country/phpcompat.yml?branch=master&label=php%207.4-8.5&style=flat-square)](https://github.com/WebberZone/webberzone-acf-country/actions/workflows/phpcompat.yml)

_Requires:_ WordPress 6.6, PHP 7.4, Advanced Custom Fields (or ACF PRO)
_Tested up to:_ PHP 8.5
_License:_ [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.html)
_Plugin page:_ [WebberZone ACF Country](https://webberzone.com/plugins/webberzone-acf-country/)

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Contributing](#contributing)
- [For Users](#for-users)
- [Changelog](#changelog)
- [License](#license)

---

## Overview

_WebberZone ACF Country_ adds a `country` field type to [Advanced Custom Fields](https://www.advancedcustomfields.com/), displaying a select field of all countries (English names, ISO 3166-1 codes).

It's a clean, minimal replacement for [nlemoine/acf-country](https://github.com/nlemoine/acf-country), built to fix that plugin's PHP 8.4 deprecations and an ACF field-registration timing bug. Field configuration and saved values use the same structure as a standard ACF select field, so it's a drop-in replacement — no data migration needed.

- _OOP & Namespaced:_ All code under `WebberZone\ACF_Country`.
- _No build step:_ hand-written JS/CSS, no npm/webpack pipeline.
- _Registers on `acf/include_field_types`:_ ACF's own lazy hook, so the field type always registers correctly regardless of theme/plugin load order.

---

## Features

- _Country select field_ for ACF, with all ISO 3166-1 countries in English
- _Allow null_, _allow multiple_, and _default value_ options, same as a core ACF select field
- _Return format:_ country code and name, country code only, or country name only
- _Filterable country list_ via the `wzacf_countries` filter

```php
add_filter( 'wzacf_countries', function( $countries ) {
	unset( $countries['AQ'] ); // Remove Antarctica.
	return $countries;
} );
```

---

## Contributing

We welcome contributions! Please:

- Fork the repository and create your branch from `master`.
- Follow the code style and structure above.
- Open issues for bugs, feature requests, or questions.

---

## For Users

See [readme.txt](./readme.txt) for installation and usage instructions. This `README.md` is intended for developers and contributors.

---

## Changelog

See [releases](https://github.com/WebberZone/webberzone-acf-country/releases) for the latest changes.

---

## License

GPL v2 or later.

---
