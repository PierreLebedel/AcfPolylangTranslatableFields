# ACF Polylang Translatable Field

This plugin adds some translatable fields to ACF for non-translated contents using Polylang

## The problem

When using Polylang, each translatable post is duplicated, and that the one that matches to the users's language is displayed. The custom fields have to be filled for each post translation.

And when using [qTanslate-XT](https://github.com/qtranslate/qtranslate-xt), the post is not duplicate, but that's the field whitch get all translated values internally. 

Sometimes, we want some duplicable post types, and some non-duplicable post types with translatable fields.

## The solution

This plugin add some fields types to the ACF choices, and when the form is saved, that's the field himself whitch got all translated values (by a JSON encoding internally).

When filling in the fields, a tab will be displayed for each of the Polylang configured languages.

![content editing languages tabs](https://github.com/PierreLebedel/AcfPolylangTranslatableFields/blob/main/screenshots/tabs1.png?raw=true)

## Installation

- Download and unzip the package file to your `wp-content/plugins/` directory

- Or install with Composer :
`composer require pleb/acf-polylang-translatable-fields`
