# ACF Polylang Translatable Field

This plugin adds some translatable fields to ACF for non-translated contents using Polylang

## The problem

When using Polylang, each translatable post is duplicated, and that the one that matches to the users's language is displayed. The custom fields have to be filled for each post translation.

And when using [qTanslate-XT](https://github.com/qtranslate/qtranslate-xt), the post is not duplicate, but that's the field whitch get all translated values internally. 

Sometimes, we want some duplicable post types, and some non-duplicable post types with translatable fields.

## The solution

This plugin add some fields types to the ACF choices, and when the post form is submitted, that's the field himself whitch got all translated values. Internally, the values are saved with a **qTranslate-like HTML comment format** : 
```
<!--:en_US-->English content<!--:--><!--:fr_FR-->Contenu en Français<!--:-->
```

When filling in the fields, a tab will be displayed for each Polylang configured languages :

![content editing languages tabs](https://github.com/PierreLebedel/AcfPolylangTranslatableFields/blob/main/screenshots/screenshot-post-tabs-01.png?raw=true)

## Installation

- Download and unzip the package file to your `wp-content/plugins/` directory

- Or install with Composer :
`composer require pleb/acf-polylang-translatable-fields`

## Usage

### Register fields

You have to choose your field type from the **Polylang translatable** group inside the ACF field type select box.

Each field type presents an additionational option, witch let you decide the empty translated value field behavior. You can choose between returning the empty value (like there is saved), and returning the default site language value instead.

### Get values in your templates

The ACF `get_field()` function returns to you the translated value in your current context Polylang language.
```
// pll_current_language('locale') => fr_FR
$translation = get_field('acf_field_name', $post_id);
echo $translation; // "Contenu en Français"
```

This function can take a **boolean third parameter** to allow you to get non-formatted values. In this case, you will receive an associative array of your field translations : 
```
$translations = get_field('acf_field_name', $post_id, false);
print_r($translations);
// array(
//   'en_EN' => "English content",
//   'fr_FR' => "Contenu en Français"
// );
```


### Update values

You can update a translated field from outside of the box by sending your values inside an associative array within ACF `update_field` function : 
```
update_field('acf_field_name', array(
    'fr_FR' => "Nouveau contenu en Français"
), $post_id);
```
The posted values will be merged with the others languages values.

Note your can also send your values with the 2 chars language slug instead of the 5 chars language locale : 
```
update_field('acf_field_name', array(
    'en' => "New english content",
    'fr' => "Nouveau contenu en Français"
), $post_id);
```

If you send non-array value to the `update_field` function, it is only the **current context Polylang language** (or the default site language if not applicable) that will be updated : 
```
// pll_current_language('locale') => es_ES
update_field('acf_field_name', "Contenido en español", $post_id);
// do the same
update_field('acf_field_name', array(
    'es_ES' => "Contenido en español"
), $post_id);
```


