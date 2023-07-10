# Statamic Meta tags

This is an add-on for Statamic 3. It gives the ability to manage and customize almost every created meta tags!

![Meta Tags index](https://web.giovannibuffa.it/github/statamic_metatags_01.png)
![Default values](https://web.giovannibuffa.it/github/statamic_metatags_02.png)

## Supperted Meta tags

- Classic meta tags, mainly used by search engines
- Site verification
- Dublin core
- Google +
- Google CSE
- Open Graph
- Facebook App
- Twitter
- Pinterest
- App links
- Mobile and UI related
- Apple proprietary
- Android proprietary
- Favicons

If you think that some meta tags are missing, open a PR!

## Installation

If you are on Statamic < 3.3 use the latest release of v1 branch:

```composer require gioppy/statamic-metatags "^1.0.4"```

If you are on Statamic >= 3.3 and < 4.0 use v2 branch:

```composer require gioppy/statamic-metatags "2.0.1"```

If you are on Statamic >= 4.0 use v3 branch

```composer require gioppy/statamic-metatags```

## How to use

All meta tags are managed through fieldsets: once the necessary categories are activated, the `metatags.yaml` fieldset is created or updated.

You can insert meta tags directly into a blueprint by selecting the metatags fieldset. **It is not necessary to set a prefix for the fieldset**.

![Fieldset](https://web.giovannibuffa.it/github/statamic_metatags_03.png)

In your template, remove the `title` tag in `layout.antlers.html` and replace it with `{{ metatags }}`.

## Credits

The add-on was inspired by the excelent [Metatag Drupal module](https://www.drupal.org/project/metatag).
