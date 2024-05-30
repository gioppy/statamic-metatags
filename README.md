# Statamic Meta tags

This is an add-on for Statamic 5. It gives the ability to manage and customize almost every created meta tags!

![Meta Tags index](https://web.giovannibuffa.it/github/statamic_metatags_4_01.png)
![Blueprints](https://web.giovannibuffa.it/github/statamic_metatags_4_02.png)
![Default values](https://web.giovannibuffa.it/github/statamic_metatags_4_03.png)

## Supperted Meta tags

- Classic meta tags, mainly used by search engines
- Site verification
- Dublin core
- ~~Google +~~
- ~~Google CSE~~
- Google Search
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

```composer require gioppy/statamic-metatags```

If you are on an older version of Statamic, please use one of these depending on your installed version.

#### Statamic < 3.3

```composer require gioppy/statamic-metatags "^1.0.4"```

#### Statamic >= 3.3 and < 4.0

```composer require gioppy/statamic-metatags "^2.0"```

#### Statamic >= 4.0 and < 5.0

```composer require gioppy/statamic-metatags "^3.0"```

## How to use

All meta tags are injected dynamically within an entry or term depending on the options selected for each individual blueprint.

In the blueprints section, under Meta Tags, you can select all the categories you want to activate for each individual blueprint. At the moment it is possible to enable meta tags only for collections and taxonomies.

In your template, remove the `title` tag in `layout.antlers.html`. For every category of meta tags you have a antlers tag to use it:

`{{ metatags:basic }}`  
`{{ metatags:advanced }}`  
`{{ metatags:dublin_core }}`  
`{{ metatags:dublin_core_advanced }}`  
`{{ metatags:opengraph }}`  
`{{ metatags:facebook }}`  
`{{ metatags:twitter }}`  
`{{ metatags:pinterest }}`  
`{{ metatags:site_verifications }}`  
`{{ metatags:app_links }}`  
`{{ metatags:mobile }}`  
`{{ metatags:apple }}`  
`{{ metatags:android }}`  
`{{ metatags:favicons }}`

## Upgrade from previous versions

Upgrading from previous versions should not cause you to lose any data within entries or terms. However, you will need to re-configure all meta tags within all blueprints.

First clear the fieldset `metatags` from all your blueprints. **Make sure not to save any content at this stage otherwise your meta tags will be deleted!**

Set the meta tags you want to use for each blueprint and the common meta tags.

Check that, by editing an entry or term, you correctly see the newly SEO tab and the values of the meta tags fields.

Edit your `layout.antlers.html` by replacing the `{{ metatags }}` tag with new antlers tags, depending on the categories you have enabled.

> [!WARNING]
> Google+ and Google CSE meta tags are no longer available!

## Credits

The add-on was inspired by the excelent [Metatag Drupal module](https://www.drupal.org/project/metatag).
