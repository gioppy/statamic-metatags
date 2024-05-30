# Statamic Meta tags

This is an add-on for Statamic 5. It gives the ability to manage and customize almost every created meta tags!

![Meta Tags index](https://web.giovannibuffa.it/github/statamic_metatags_4_01.png)
![Blueprints](https://web.giovannibuffa.it/github/statamic_metatags_4_02.png)
![Default values](https://web.giovannibuffa.it/github/statamic_metatags_4_03.png)

## Supperted Meta tags

- Classic meta tags, mainly used by search engines
- Site verification
- Dublin core
- Google + (currently not output on template)
- Google CSE (currently not output on template)
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

If you are on Statamic >= 4.0 and < 5.0 use v3 branch

```composer require gioppy/statamic-metatags "^3.0"```

If you are on Statamic >= 5.0 use v4 branch

```composer require gioppy/statamic-metatags```

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

## Credits

The add-on was inspired by the excelent [Metatag Drupal module](https://www.drupal.org/project/metatag).
