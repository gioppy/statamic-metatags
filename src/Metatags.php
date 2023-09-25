<?php


namespace Gioppy\StatamicMetatags;


use Illuminate\Support\Str;
use Statamic\Facades\Site;

class Metatags {

  private $fields;

  public function __construct() {
    $this->fields = collect();
  }

  public static function make() {
    return new static();
  }

  public function get() {
    return $this->fields;
  }

  public function features() {
    $settings = Settings::make()->values();

    $features = collect($settings)->except(['site_name', 'site_name_separator'])
      ->collapse()
      ->all();

    $hasMultisite = Site::hasMultiple();

    foreach ($features as $feature) {
      $method = Str::camel($feature);
      $this->fields = $this->fields->merge($this->$method($hasMultisite)->get());
    }

    return $this->fields->values()->all();
  }

  protected function basic(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'basic',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.basic'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'basic_title',
        'field' => [
          'display' => __('statamic-metatags::basic.title'),
          'instructions' => __('statamic-metatags::basic.title_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'basic_description',
        'field' => [
          'display' => __('statamic-metatags::basic.description'),
          'instructions' => __('statamic-metatags::basic.description_instructions'),
          'type' => 'textarea',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'basic_keywords',
        'field' => [
          'display' => __('statamic-metatags::basic.keywords'),
          'instructions' => __('statamic-metatags::basic.keywords_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'basic_robots',
        'field' => [
          'display' => __('statamic-metatags::basic.robots'),
          'instructions' => __('statamic-metatags::basic.robots_instructions'),
          'options' => [
            'noindex',
            'nofollow',
            'noarchive',
            'nosnippet',
            'noodp',
            'noydir',
            'noimageindex',
            'notranslate',
          ],
          'multiple' => true,
          'clearable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function advanced(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'advanced',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.advanced'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'advanced_author',
        'field' => [
          'display' => __('statamic-metatags::advanced.author'),
          'instructions' => __('statamic-metatags::advanced.author_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_generator',
        'field' => [
          'display' => __('statamic-metatags::advanced.generator'),
          'instructions' => __('statamic-metatags::advanced.generator_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_image',
        'field' => [
          'display' => __('statamic-metatags::advanced.image'),
          'instructions' => __('statamic-metatags::advanced.image_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_rights',
        'field' => [
          'display' => __('statamic-metatags::advanced.rights'),
          'instructions' => __('statamic-metatags::advanced.rights_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_rating',
        'field' => [
          'display' => __('statamic-metatags::advanced.rating'),
          'instructions' => __('statamic-metatags::advanced.rating_instructions'),
          'options' => [
            'general' => 'General',
            'mature' => 'Mature',
            'restricted' => 'Restricted',
            '14 years' => '14 years or Older',
            'safe for kids' => 'Safe for kids',
          ],
          'clearable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_referrer',
        'field' => [
          'display' => __('statamic-metatags::advanced.referrer'),
          'instructions' => __('statamic-metatags::advanced.referrer_instructions'),
          'options' => [
            'no-referrer' => 'No Referrer',
            'origin' => 'Origin',
            'no-referrer-when-downgrade' => 'No Referrer When Downgrade',
            'origin-when-cross-origin' => 'Origin When Cross-Origin',
            'unsafe-url' => 'Unsafe URL',
          ],
          'clearable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_canonical',
        'field' => [
          'display' => __('statamic-metatags::advanced.canonical'),
          'instructions' => __('statamic-metatags::advanced.canonical_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_short_link',
        'field' => [
          'display' => __('statamic-metatags::advanced.short_link'),
          'instructions' => __('statamic-metatags::advanced.short_link_instructions'),
          'type' => 'text',
          'input_type' => 'url',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_original_source',
        'field' => [
          'display' => __('statamic-metatags::advanced.original_source'),
          'instructions' => __('statamic-metatags::advanced.original_source_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_geo_position',
        'field' => [
          'display' => __('statamic-metatags::advanced.geo_position'),
          'instructions' => __('statamic-metatags::advanced.geo_position_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_geo_placename',
        'field' => [
          'display' => __('statamic-metatags::advanced.geo_placename'),
          'instructions' => __('statamic-metatags::advanced.geo_placename_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_geo_region',
        'field' => [
          'display' => __('statamic-metatags::advanced.geo_region'),
          'instructions' => __('statamic-metatags::advanced.geo_region_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_icbm',
        'field' => [
          'display' => __('statamic-metatags::advanced.icbm'),
          'instructions' => __('statamic-metatags::advanced.icbm_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'advanced_refresh',
        'field' => [
          'display' => __('statamic-metatags::advanced.refresh'),
          'instructions' => __('statamic-metatags::advanced.refresh_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ]
    ];

    return $this;
  }

  protected function siteVerifications(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'site_verifications',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.site_verifications'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'site_verifications_bing',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.bing'),
          'instructions' => __('statamic-metatags::site_verifications.bing_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_baidu',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.baidu'),
          'instructions' => __('statamic-metatags::site_verifications.baidu_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_google',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.google'),
          'instructions' => __('statamic-metatags::site_verifications.google_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_norton',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.norton'),
          'instructions' => __('statamic-metatags::site_verifications.norton_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_pinterest',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.pinterest'),
          'instructions' => __('statamic-metatags::site_verifications.pinterest_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_pocket',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.pocket'),
          'instructions' => __('statamic-metatags::site_verifications.pocket_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_yandex',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.yandex'),
          'instructions' => __('statamic-metatags::site_verifications.yandex_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'site_verifications_zoom',
        'field' => [
          'display' => __('statamic-metatags::site_verifications.zoom'),
          'instructions' => __('statamic-metatags::site_verifications.zoom_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function dublinCore(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'dublin_core',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.dublin_core'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'dublin_core_title',
        'field' => [
          'display' => __('statamic-metatags::dc.title'),
          'instructions' => __('statamic-metatags::dc.title_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_creator',
        'field' => [
          'display' => __('statamic-metatags::dc.creator'),
          'instructions' => __('statamic-metatags::dc.creator_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_subject',
        'field' => [
          'display' => __('statamic-metatags::dc.subject'),
          'instructions' => __('statamic-metatags::dc.subject_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_description',
        'field' => [
          'display' => __('statamic-metatags::dc.description'),
          'instructions' => __('statamic-metatags::dc.description_instructions'),
          'type' => 'textarea',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_publisher',
        'field' => [
          'display' => __('statamic-metatags::dc.publisher'),
          'instructions' => __('statamic-metatags::dc.publisher_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_contributor',
        'field' => [
          'display' => __('statamic-metatags::dc.contributor'),
          'instructions' => __('statamic-metatags::dc.contributor_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_date',
        'field' => [
          'display' => __('statamic-metatags::dc.date'),
          'instructions' => __('statamic-metatags::dc.date_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_type',
        'field' => [
          'display' => __('statamic-metatags::dc.type'),
          'instructions' => __('statamic-metatags::dc.type_instructions'),
          'options' => [
            'Collection' => 'Collection',
            'Dataset' => 'Dataset',
            'Event' => 'Event',
            'Image' => 'Image',
            'InteractiveResource' => 'Interactive Resource',
            'MovingImage' => 'Moving Image',
            'PhysicalObject' => 'Physical Object',
            'Service' => 'Service',
            'Software' => 'Software',
            'Sound' => 'Sound',
            'StillImage' => 'Still Image',
            'Text' => 'Text',
          ],
          'type' => 'select',
          'clearable' => true,
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_format',
        'field' => [
          'display' => __('statamic-metatags::dc.format'),
          'instructions' => __('statamic-metatags::dc.format_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_identifier',
        'field' => [
          'display' => __('statamic-metatags::dc.identifier'),
          'instructions' => __('statamic-metatags::dc.identifier_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_source',
        'field' => [
          'display' => __('statamic-metatags::dc.source'),
          'instructions' => __('statamic-metatags::dc.source_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_language',
        'field' => [
          'display' => __('statamic-metatags::dc.language'),
          'instructions' => __('statamic-metatags::dc.language_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_relation',
        'field' => [
          'display' => __('statamic-metatags::dc.relation'),
          'instructions' => __('statamic-metatags::dc.relation_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_coverage',
        'field' => [
          'display' => __('statamic-metatags::dc.coverage'),
          'instructions' => __('statamic-metatags::dc.coverage_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_rights',
        'field' => [
          'display' => __('statamic-metatags::dc.rights'),
          'instructions' => __('statamic-metatags::dc.rights_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function dublinCoreAdvanced(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'dublin_core_advanced',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.dublin_core_advanced'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_abstract',
        'field' => [
          'display' => __('statamic-metatags::dc.abstract'),
          'instructions' => __('statamic-metatags::dc.abstract_instructions'),
          'type' => 'textarea',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_access_rights',
        'field' => [
          'display' => __('statamic-metatags::dc.access_rights'),
          'instructions' => __('statamic-metatags::dc.access_rights_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_accrual_method',
        'field' => [
          'display' => __('statamic-metatags::dc.accrual_method'),
          'instructions' => __('statamic-metatags::dc.accrual_method_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_accrual_periodicity',
        'field' => [
          'display' => __('statamic-metatags::dc.accrual_periodicity'),
          'instructions' => __('statamic-metatags::dc.accrual_periodicity_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_accrual_policy',
        'field' => [
          'display' => __('statamic-metatags::dc.accrual_policy'),
          'instructions' => __('statamic-metatags::dc.accrual_policy_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_alternative',
        'field' => [
          'display' => __('statamic-metatags::dc.alternative'),
          'instructions' => __('statamic-metatags::dc.alternative_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_audience',
        'field' => [
          'display' => __('statamic-metatags::dc.audience'),
          'instructions' => __('statamic-metatags::dc.audience_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_available',
        'field' => [
          'display' => __('statamic-metatags::dc.available'),
          'instructions' => __('statamic-metatags::dc.available_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_bibliographic_citation',
        'field' => [
          'display' => __('statamic-metatags::dc.bibliographic_citation'),
          'instructions' => __('statamic-metatags::dc.bibliographic_citation_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_conforms_to',
        'field' => [
          'display' => __('statamic-metatags::dc.conforms_to'),
          'instructions' => __('statamic-metatags::dc.conforms_to_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_created',
        'field' => [
          'display' => __('statamic-metatags::dc.created'),
          'instructions' => __('statamic-metatags::dc.created_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_date_accepted',
        'field' => [
          'display' => __('statamic-metatags::dc.date_accepted'),
          'instructions' => __('statamic-metatags::dc.date_accepted_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_date_copyrighted',
        'field' => [
          'display' => __('statamic-metatags::dc.date_copyrighted'),
          'instructions' => __('statamic-metatags::dc.date_copyrighted_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_date_submitted',
        'field' => [
          'display' => __('statamic-metatags::dc.date_submitted'),
          'instructions' => __('statamic-metatags::dc.date_submitted_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_education_level',
        'field' => [
          'display' => __('statamic-metatags::dc.education_level'),
          'instructions' => __('statamic-metatags::dc.education_level_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_extent',
        'field' => [
          'display' => __('statamic-metatags::dc.extent'),
          'instructions' => __('statamic-metatags::dc.extent_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_has_format',
        'field' => [
          'display' => __('statamic-metatags::dc.has_format'),
          'instructions' => __('statamic-metatags::dc.has_format_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_has_part',
        'field' => [
          'display' => __('statamic-metatags::dc.has_part'),
          'instructions' => __('statamic-metatags::dc.has_part_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_has_version',
        'field' => [
          'display' => __('statamic-metatags::dc.has_version'),
          'instructions' => __('statamic-metatags::dc.has_version_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_instructional_method',
        'field' => [
          'display' => __('statamic-metatags::dc.instructional_method'),
          'instructions' => __('statamic-metatags::dc.instructional_method_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_format_of',
        'field' => [
          'display' => __('statamic-metatags::dc.is_format_of'),
          'instructions' => __('statamic-metatags::dc.is_format_of_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_part_of',
        'field' => [
          'display' => __('statamic-metatags::dc.is_part_of'),
          'instructions' => __('statamic-metatags::dc.is_part_of_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_referenced_by',
        'field' => [
          'display' => __('statamic-metatags::dc.is_referenced_by'),
          'instructions' => __('statamic-metatags::dc.is_referenced_by_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_replaced_by',
        'field' => [
          'display' => __('statamic-metatags::dc.is_replaced_by'),
          'instructions' => __('statamic-metatags::dc.is_replaced_by_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_required_by',
        'field' => [
          'display' => __('statamic-metatags::dc.is_required_by'),
          'instructions' => __('statamic-metatags::dc.is_required_by_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_issued',
        'field' => [
          'display' => __('statamic-metatags::dc.issued'),
          'instructions' => __('statamic-metatags::dc.issued_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_is_version_of',
        'field' => [
          'display' => __('statamic-metatags::dc.is_version_of'),
          'instructions' => __('statamic-metatags::dc.is_version_of_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_license',
        'field' => [
          'display' => __('statamic-metatags::dc.license'),
          'instructions' => __('statamic-metatags::dc.license_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_mediator',
        'field' => [
          'display' => __('statamic-metatags::dc.mediator'),
          'instructions' => __('statamic-metatags::dc.mediator_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_medium',
        'field' => [
          'display' => __('statamic-metatags::dc.medium'),
          'instructions' => __('statamic-metatags::dc.medium_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_modified',
        'field' => [
          'display' => __('statamic-metatags::dc.modified'),
          'instructions' => __('statamic-metatags::dc.modified_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_provenance',
        'field' => [
          'display' => __('statamic-metatags::dc.provenance'),
          'instructions' => __('statamic-metatags::dc.provenance_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_references',
        'field' => [
          'display' => __('statamic-metatags::dc.references'),
          'instructions' => __('statamic-metatags::dc.references_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_replaces',
        'field' => [
          'display' => __('statamic-metatags::dc.replaces'),
          'instructions' => __('statamic-metatags::dc.replaces_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_requires',
        'field' => [
          'display' => __('statamic-metatags::dc.requires'),
          'instructions' => __('statamic-metatags::dc.requires_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_rights_holder',
        'field' => [
          'display' => __('statamic-metatags::dc.rights_holder'),
          'instructions' => __('statamic-metatags::dc.rights_holder_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_spatial',
        'field' => [
          'display' => __('statamic-metatags::dc.spatial'),
          'instructions' => __('statamic-metatags::dc.spatial_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_table_of_contents',
        'field' => [
          'display' => __('statamic-metatags::dc.table_of_contents'),
          'instructions' => __('statamic-metatags::dc.table_of_contents_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_temporal',
        'field' => [
          'display' => __('statamic-metatags::dc.temporal'),
          'instructions' => __('statamic-metatags::dc.temporal_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'dublin_core_advanced_valid',
        'field' => [
          'display' => __('statamic-metatags::dc.valid'),
          'instructions' => __('statamic-metatags::dc.valid_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function googlePlus(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'google_plus',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.google_plus'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'google_plus_itemtype',
        'field' => [
          'display' => __('statamic-metatags::google_plus.itemtype'),
          'instructions' => __('statamic-metatags::google_plus.itemtype_instructions'),
          'options' => [
            'Article' => 'Article',
            'Blog' => 'Blog',
            'Book' => 'Book',
            'Event' => 'Event',
            'LocalBusiness' => 'Local Business',
            'Organization' => 'Organization',
            'Person' => 'Person',
            'Product' => 'Product',
            'Review' => 'Review',
          ],
          'clearable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_plus_title',
        'field' => [
          'display' => __('statamic-metatags::google_plus.itemprop_name'),
          'instructions' => __('statamic-metatags::google_plus.itemprop_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_plus_description',
        'field' => [
          'display' => __('statamic-metatags::google_plus.itemprop_description'),
          'instructions' => __('statamic-metatags::google_plus.itemprop_description_instructions'),
          'type' => 'textarea',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_plus_publisher',
        'field' => [
          'display' => __('statamic-metatags::google_plus.publisher'),
          'instructions' => __('statamic-metatags::google_plus.publisher_instructions'),
          'input_type' => 'url',
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function googleCSE(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'google_cse',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.google_cse'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'google_cse_department',
        'field' => [
          'display' => __('statamic-metatags::google_cse.department'),
          'instructions' => __('statamic-metatags::google_cse.department_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_cse_audience',
        'field' => [
          'display' => __('statamic-metatags::google_cse.audience'),
          'instructions' => __('statamic-metatags::google_cse.audience_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_cse_doc_status',
        'field' => [
          'display' => __('statamic-metatags::google_cse.doc_status'),
          'instructions' => __('statamic-metatags::google_cse.doc_status_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'google_cse_google_rating',
        'field' => [
          'display' => __('statamic-metatags::google_cse.google_rating'),
          'instructions' => __('statamic-metatags::google_cse.google_rating_instructions'),
          'input_type' => 'number',
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function og(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'og',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.og'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'og_type',
        'field' => [
          'display' => __('statamic-metatags::og.type'),
          'instructions' => __('statamic-metatags::og.type_instructions'),
          'options' => [
            'article' => 'Article',
            'book' => 'Book',
            'music.song' => 'Song',
            'music.album' => 'Album',
            'music.playlist' => 'Playlist',
            'music.radio_station' => 'Radio station',
            'product' => 'Product',
            'profile' => 'Profile',
            'video.movie' => 'Movie',
            'video.tv_show' => 'TV show',
            'video.episode' => 'TV show episode',
            'video.other' => 'Miscellaneous video',
            'website' => 'Website',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_title',
        'field' => [
          'display' => __('statamic-metatags::og.title'),
          'instructions' => __('statamic-metatags::og.title_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_image',
        'field' => [
          'display' => __('statamic-metatags::og.image'),
          'instructions' => __('statamic-metatags::og.image_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_audio',
        'field' => [
          'display' => __('statamic-metatags::og.audio'),
          'instructions' => __('statamic-metatags::og.audio_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video',
        'field' => [
          'display' => __('statamic-metatags::og.video'),
          'instructions' => __('statamic-metatags::og.video_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_determiner',
        'field' => [
          'display' => __('statamic-metatags::og.determiner'),
          'instructions' => __('statamic-metatags::og.determiner_instructions'),
          'options' => [
            'auto' => 'Auto',
            'a' => 'A',
            'an' => 'An',
            'the' => 'The',
          ],
          'clearable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_description',
        'field' => [
          'display' => __('statamic-metatags::og.description'),
          'instructions' => __('statamic-metatags::og.description_instructions'),
          'type' => 'textarea',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_locale_alternate',
        'field' => [
          'display' => __('statamic-metatags::og.locale_alternate'),
          'instructions' => __('statamic-metatags::og.locale_alternate_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_author',
        'field' => [
          'display' => __('statamic-metatags::og.article_author'),
          'instructions' => __('statamic-metatags::og.article_author_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_section',
        'field' => [
          'display' => __('statamic-metatags::og.article_section'),
          'instructions' => __('statamic-metatags::og.article_section_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_tag',
        'field' => [
          'display' => __('statamic-metatags::og.article_tag'),
          'instructions' => __('statamic-metatags::og.article_tag_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_published_time',
        'field' => [
          'display' => __('statamic-metatags::og.article_published_time'),
          'instructions' => __('statamic-metatags::og.article_published_time_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_modified_time',
        'field' => [
          'display' => __('statamic-metatags::og.article_modified_time'),
          'instructions' => __('statamic-metatags::og.article_modified_time_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_article_expiration_time',
        'field' => [
          'display' => __('statamic-metatags::og.article_expiration_time'),
          'instructions' => __('statamic-metatags::og.article_expiration_time_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'og_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_actor',
        'field' => [
          'display' => __('statamic-metatags::og.video_actor'),
          'instructions' => __('statamic-metatags::og.video_actor_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_actor_role',
        'field' => [
          'display' => __('statamic-metatags::og.video_actor_role'),
          'instructions' => __('statamic-metatags::og.video_actor_role_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_director',
        'field' => [
          'display' => __('statamic-metatags::og.video_director'),
          'instructions' => __('statamic-metatags::og.video_director_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_writer',
        'field' => [
          'display' => __('statamic-metatags::og.video_writer'),
          'instructions' => __('statamic-metatags::og.video_writer_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_duration',
        'field' => [
          'display' => __('statamic-metatags::og.video_duration'),
          'instructions' => __('statamic-metatags::og.video_duration_instructions'),
          'input_type' => 'number',
          'type' => 'text',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_release_date',
        'field' => [
          'display' => __('statamic-metatags::og.video_release_date'),
          'instructions' => __('statamic-metatags::og.video_release_date_instructions'),
          'time_enabled' => false,
          'type' => 'date',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_tag',
        'field' => [
          'display' => __('statamic-metatags::og.video_tag'),
          'instructions' => __('statamic-metatags::og.video_tag_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains video.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_video_series',
        'field' => [
          'display' => __('statamic-metatags::og.video_series'),
          'instructions' => __('statamic-metatags::og.video_series_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals video.episode',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_book_author',
        'field' => [
          'display' => __('statamic-metatags::og.book_author'),
          'instructions' => __('statamic-metatags::og.book_author_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals book',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_book_isbn',
        'field' => [
          'display' => __('statamic-metatags::og.book_isbn'),
          'instructions' => __('statamic-metatags::og.book_isbn_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals book',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_book_release_date',
        'field' => [
          'display' => __('statamic-metatags::og.book_release_date'),
          'instructions' => __('statamic-metatags::og.book_release_date_instructions'),
          'time_enabled' => false,
          'type' => 'date',
          'if' => [
            'og_type' => 'equals book',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_book_tag',
        'field' => [
          'display' => __('statamic-metatags::og.book_tag'),
          'instructions' => __('statamic-metatags::og.book_tag_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals book',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_profile_first_name',
        'field' => [
          'display' => __('statamic-metatags::og.profile_first_name'),
          'instructions' => __('statamic-metatags::og.profile_first_name_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals profile',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_profile_last_name',
        'field' => [
          'display' => __('statamic-metatags::og.profile_last_name'),
          'instructions' => __('statamic-metatags::og.profile_last_name_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals profile',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_profile_username',
        'field' => [
          'display' => __('statamic-metatags::og.profile_username'),
          'instructions' => __('statamic-metatags::og.profile_username_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals profile',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_profile_gender',
        'field' => [
          'display' => __('statamic-metatags::og.profile_gender'),
          'instructions' => __('statamic-metatags::og.profile_gender_instructions'),
          'options' => [
            'male' => 'Male',
            'female' => 'Female',
          ],
          'clearable' => true,
          'type' => 'select',
          'if' => [
            'og_type' => 'equals profile',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_product_plural_title',
        'field' => [
          'display' => __('statamic-metatags::og.product_plural_title'),
          'instructions' => __('statamic-metatags::og.product_plural_title_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_product_price_amount',
        'field' => [
          'display' => __('statamic-metatags::og.product_price_amount'),
          'instructions' => __('statamic-metatags::og.product_price_amount_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_product_price_currency',
        'field' => [
          'display' => __('statamic-metatags::og.product_price_currency'),
          'instructions' => __('statamic-metatags::og.product_price_currency_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_duration',
        'field' => [
          'display' => __('statamic-metatags::og.music_duration'),
          'instructions' => __('statamic-metatags::og.music_duration_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_album',
        'field' => [
          'display' => __('statamic-metatags::og.music_album'),
          'instructions' => __('statamic-metatags::og.music_album_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_album_disc',
        'field' => [
          'display' => __('statamic-metatags::og.music_album_disc'),
          'instructions' => __('statamic-metatags::og.music_album_disc_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_album_track',
        'field' => [
          'display' => __('statamic-metatags::og.music_album_track'),
          'instructions' => __('statamic-metatags::og.music_album_track_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_musician',
        'field' => [
          'display' => __('statamic-metatags::og.music_musician'),
          'instructions' => __('statamic-metatags::og.music_musician_instructions'),
          'type' => 'taggable',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_song',
        'field' => [
          'display' => __('statamic-metatags::og.music_song'),
          'instructions' => __('statamic-metatags::og.music_song_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_song_disc',
        'field' => [
          'display' => __('statamic-metatags::og.music_song_disc'),
          'instructions' => __('statamic-metatags::og.music_song_disc_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_song_track',
        'field' => [
          'display' => __('statamic-metatags::og.music_song_track'),
          'instructions' => __('statamic-metatags::og.music_song_track_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_release_date',
        'field' => [
          'display' => __('statamic-metatags::og.music_release_date'),
          'instructions' => __('statamic-metatags::og.music_release_date_instructions'),
          'time_enabled' => false,
          'type' => 'date',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'og_music_creator',
        'field' => [
          'display' => __('statamic-metatags::og.music_creator'),
          'instructions' => __('statamic-metatags::og.music_creator_instructions'),
          'type' => 'text',
          'if' => [
            'og_type' => 'contains music.',
          ],
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function facebook(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'facebook',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.facebook'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'facebook_admins',
        'field' => [
          'display' => __('statamic-metatags::facebook.admins'),
          'instructions' => __('statamic-metatags::facebook.admins_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'facebook_app_id',
        'field' => [
          'display' => __('statamic-metatags::facebook.app_id'),
          'instructions' => __('statamic-metatags::facebook.app_id_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function twitter(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'twitter',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.twitter'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'twitter_type',
        'field' => [
          'display' => __('statamic-metatags::twitter.type'),
          'instructions' => __('statamic-metatags::twitter.type_instructions'),
          'options' => [
            'summary' => 'Summary',
            'summary_large_image' => 'Summary with large image',
            'app' => 'App',
            'player' => 'Player',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_site',
        'field' => [
          'display' => __('statamic-metatags::twitter.site'),
          'instructions' => __('statamic-metatags::twitter.site_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_site_id',
        'field' => [
          'display' => __('statamic-metatags::twitter.site_id'),
          'instructions' => __('statamic-metatags::twitter.site_id_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'not app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_creator',
        'field' => [
          'display' => __('statamic-metatags::twitter.creator'),
          'instructions' => __('statamic-metatags::twitter.creator_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals summary_large_image',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_creator_id',
        'field' => [
          'display' => __('statamic-metatags::twitter.creator_id'),
          'instructions' => __('statamic-metatags::twitter.creator_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_description',
        'field' => [
          'display' => __('statamic-metatags::twitter.description'),
          'instructions' => __('statamic-metatags::twitter.description_instructions'),
          'type' => 'textarea',
          'if' => [
            'twitter_type' => 'not app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_title',
        'field' => [
          'display' => __('statamic-metatags::twitter.title'),
          'instructions' => __('statamic-metatags::twitter.title_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'not app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_image',
        'field' => [
          'display' => __('statamic-metatags::twitter.image'),
          'instructions' => __('statamic-metatags::twitter.image_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'type' => 'assets',
          'max_files' => 1,
          'if' => [
            'twitter_type' => 'not app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_player',
        'field' => [
          'display' => __('statamic-metatags::twitter.player'),
          'instructions' => __('statamic-metatags::twitter.player_instructions'),
          'type' => 'text',
          'input_type' => 'url',
          'if' => [
            'twitter_type' => 'equals player',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_player_width',
        'field' => [
          'display' => __('statamic-metatags::twitter.player_width'),
          'instructions' => __('statamic-metatags::twitter.player_width_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'twitter_type' => 'equals player',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_player_height',
        'field' => [
          'display' => __('statamic-metatags::twitter.player_height'),
          'instructions' => __('statamic-metatags::twitter.player_height_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'if' => [
            'twitter_type' => 'equals player',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_player_stream',
        'field' => [
          'display' => __('statamic-metatags::twitter.player_stream'),
          'instructions' => __('statamic-metatags::twitter.player_stream_instructions'),
          'type' => 'text',
          'input_type' => 'url',
          'if' => [
            'twitter_type' => 'equals player',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_name_iphone',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_name_iphone'),
          'instructions' => __('statamic-metatags::twitter.app_name_iphone_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_id_iphone',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_id_iphone'),
          'instructions' => __('statamic-metatags::twitter.app_id_iphone_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_url_iphone',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_url_iphone'),
          'instructions' => __('statamic-metatags::twitter.app_url_iphone_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_name_ipad',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_name_ipad'),
          'instructions' => __('statamic-metatags::twitter.app_name_ipad_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_id_ipad',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_id_ipad'),
          'instructions' => __('statamic-metatags::twitter.app_id_ipad_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_url_ipad',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_url_ipad'),
          'instructions' => __('statamic-metatags::twitter.app_url_ipad_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_name_googleplay',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_name_googleplay'),
          'instructions' => __('statamic-metatags::twitter.app_name_googleplay_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_id_googleplay',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_id_googleplay'),
          'instructions' => __('statamic-metatags::twitter.app_id_googleplay_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'twitter_app_url_googleplay',
        'field' => [
          'display' => __('statamic-metatags::twitter.app_url_googleplay'),
          'instructions' => __('statamic-metatags::twitter.app_url_googleplay_instructions'),
          'type' => 'text',
          'if' => [
            'twitter_type' => 'equals app',
          ],
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function pinterest(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'pinterest',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.pinterest'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'pinterest_image',
        'field' => [
          'display' => __('statamic-metatags::pinterest.image'),
          'instructions' => __('statamic-metatags::pinterest.image_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 6,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_see_also',
        'field' => [
          'display' => __('statamic-metatags::pinterest.see_also'),
          'instructions' => __('statamic-metatags::pinterest.see_also_instructions'),
          'type' => 'list',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_referenced',
        'field' => [
          'display' => __('statamic-metatags::pinterest.referenced'),
          'instructions' => __('statamic-metatags::pinterest.referenced_instructions'),
          'type' => 'text',
          'input_type' => 'url',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_rating',
        'field' => [
          'display' => __('statamic-metatags::pinterest.rating'),
          'instructions' => __('statamic-metatags::pinterest.rating_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_rating_scale',
        'field' => [
          'display' => __('statamic-metatags::pinterest.rating_scale'),
          'instructions' => __('statamic-metatags::pinterest.rating_scale_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_rating_count',
        'field' => [
          'display' => __('statamic-metatags::pinterest.rating_count'),
          'instructions' => __('statamic-metatags::pinterest.rating_count_instructions'),
          'type' => 'text',
          'input_type' => 'number',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_type',
        'field' => [
          'display' => __('statamic-metatags::pinterest.type'),
          'instructions' => __('statamic-metatags::pinterest.type_instructions'),
          'options' => [
            'article' => 'Article',
            'product' => 'Product',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_modified_time',
        'field' => [
          'display' => __('statamic-metatags::pinterest.modified_time'),
          'instructions' => __('statamic-metatags::pinterest.modified_time_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'pinterest_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_section',
        'field' => [
          'display' => __('statamic-metatags::pinterest.section'),
          'instructions' => __('statamic-metatags::pinterest.section_instructions'),
          'type' => 'text',
          'if' => [
            'pinterest_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_tag',
        'field' => [
          'display' => __('statamic-metatags::pinterest.tag'),
          'instructions' => __('statamic-metatags::pinterest.tag_instructions'),
          'type' => 'taggable',
          'if' => [
            'pinterest_type' => 'equals article',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_code_type',
        'field' => [
          'display' => __('statamic-metatags::pinterest.code_type'),
          'instructions' => __('statamic-metatags::pinterest.code_type_instructions'),
          'options' => [
            'og:upc' => 'UPC',
            'og:ean' => 'EAN',
            'og:isbn' => 'ISBN',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'width' => 50,
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_code_id',
        'field' => [
          'display' => __('statamic-metatags::pinterest.code_id'),
          'instructions' => __('statamic-metatags::pinterest.code_id_instructions'),
          'type' => 'text',
          'width' => 50,
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_availability_destinations',
        'field' => [
          'display' => __('statamic-metatags::pinterest.availability_destinations'),
          'instructions' => __('statamic-metatags::pinterest.availability_destinations_instructions'),
          'type' => 'taggable',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_start_date',
        'field' => [
          'display' => __('statamic-metatags::pinterest.start_date'),
          'instructions' => __('statamic-metatags::pinterest.start_date_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_end_date',
        'field' => [
          'display' => __('statamic-metatags::pinterest.end_date'),
          'instructions' => __('statamic-metatags::pinterest.end_date_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_expiration_time',
        'field' => [
          'display' => __('statamic-metatags::pinterest.expiration_time'),
          'instructions' => __('statamic-metatags::pinterest.expiration_time_instructions'),
          'time_enabled' => true,
          'type' => 'date',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_gender',
        'field' => [
          'display' => __('statamic-metatags::pinterest.gender'),
          'instructions' => __('statamic-metatags::pinterest.gender_instructions'),
          'options' => [
            'male' => 'Male',
            'female' => 'Female',
            'unisex' => 'Unisex',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_color',
        'field' => [
          'display' => __('statamic-metatags::pinterest.color'),
          'instructions' => __('statamic-metatags::pinterest.color_instructions'),
          'type' => 'taggable',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_color_map',
        'field' => [
          'display' => __('statamic-metatags::pinterest.color_map'),
          'instructions' => __('statamic-metatags::pinterest.color_map_instructions'),
          'options' => [
            'beige' => 'Beige',
            'black' => 'Black',
            'blue' => 'Blue',
            'bronze' => 'Bronze',
            'brown' => 'Brown',
            'gold' => 'Gold',
            'green' => 'Green',
            'gray' => 'Gray',
            'metallic' => 'Metallic',
            'multicolored' => 'Multicolored',
            'off-white' => 'Off',
            'orange' => 'Orange',
            'pink' => 'Pink',
            'purple' => 'Purple',
            'red' => 'Red',
            'silver' => 'Silver',
            'transparent' => 'Transparent',
            'turquoise' => 'Turquoise',
            'white' => 'White',
            'yellow' => 'Yellow',
          ],
          'clearable' => true,
          'searchable' => true,
          'type' => 'select',
          'multiple' => true,
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'pinterest_color_image',
        'field' => [
          'display' => __('statamic-metatags::pinterest.color_image'),
          'instructions' => __('statamic-metatags::pinterest.color_image_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'type' => 'assets',
          'if' => [
            'pinterest_type' => 'equals product',
          ],
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function appLinks(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'app_links',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.app_links'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'app_links_ios_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.ios_url'),
          'instructions' => __('statamic-metatags::app_links.ios_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_ios_app_store_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.ios_app_store_id'),
          'instructions' => __('statamic-metatags::app_links.ios_app_store_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_ios_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.ios_app_name'),
          'instructions' => __('statamic-metatags::app_links.ios_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_iphone_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.iphone_url'),
          'instructions' => __('statamic-metatags::app_links.iphone_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_iphone_app_store_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.iphone_app_store_id'),
          'instructions' => __('statamic-metatags::app_links.iphone_app_store_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_iphone_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.iphone_app_name'),
          'instructions' => __('statamic-metatags::app_links.iphone_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_ipad_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.ipad_url'),
          'instructions' => __('statamic-metatags::app_links.ipad_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_ipad_app_store_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.ipad_app_store_id'),
          'instructions' => __('statamic-metatags::app_links.ipad_app_store_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_ipad_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.ipad_app_name'),
          'instructions' => __('statamic-metatags::app_links.ipad_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_android_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.android_url'),
          'instructions' => __('statamic-metatags::app_links.android_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_android_package',
        'field' => [
          'display' => __('statamic-metatags::app_links.android_package'),
          'instructions' => __('statamic-metatags::app_links.android_package_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_android_class',
        'field' => [
          'display' => __('statamic-metatags::app_links.android_class'),
          'instructions' => __('statamic-metatags::app_links.android_class_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_android_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.android_app_name'),
          'instructions' => __('statamic-metatags::app_links.android_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_wp_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.wp_url'),
          'instructions' => __('statamic-metatags::app_links.wp_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_wp_app_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.wp_app_id'),
          'instructions' => __('statamic-metatags::app_links.wp_app_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_wp_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.wp_app_name'),
          'instructions' => __('statamic-metatags::app_links.wp_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_url'),
          'instructions' => __('statamic-metatags::app_links.win_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_app_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_app_id'),
          'instructions' => __('statamic-metatags::app_links.win_app_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_app_name'),
          'instructions' => __('statamic-metatags::app_links.win_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_uni_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_uni_url'),
          'instructions' => __('statamic-metatags::app_links.win_uni_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_uni_app_id',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_uni_app_id'),
          'instructions' => __('statamic-metatags::app_links.win_uni_app_id_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_win_uni_app_name',
        'field' => [
          'display' => __('statamic-metatags::app_links.win_uni_app_name'),
          'instructions' => __('statamic-metatags::app_links.win_uni_app_name_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_web_url',
        'field' => [
          'display' => __('statamic-metatags::app_links.web_url'),
          'instructions' => __('statamic-metatags::app_links.web_url_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'app_links_web_should_fallback',
        'field' => [
          'display' => __('statamic-metatags::app_links.web_should_fallback'),
          'instructions' => __('statamic-metatags::app_links.web_should_fallback_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function mobile(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'mobile',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.mobile'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'mobile_viewport',
        'field' => [
          'display' => __('statamic-metatags::mobile.viewport'),
          'instructions' => __('statamic-metatags::mobile.viewport_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'mobile_mobile_optimized',
        'field' => [
          'display' => __('statamic-metatags::mobile.mobile_optimized'),
          'instructions' => __('statamic-metatags::mobile.mobile_optimized_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'mobile_handheld_friendly',
        'field' => [
          'display' => __('statamic-metatags::mobile.handheld_friendly'),
          'instructions' => __('statamic-metatags::mobile.handheld_friendly_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function apple(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'apple',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.apple'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'apple_format_detection',
        'field' => [
          'display' => __('statamic-metatags::apple.format_detection'),
          'instructions' => __('statamic-metatags::apple.format_detection_instructions'),
          'type' => 'taggable',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'apple_apple_itunes_app',
        'field' => [
          'display' => __('statamic-metatags::apple.apple_itunes_app'),
          'instructions' => __('statamic-metatags::apple.apple_itunes_app_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'apple_apple_mobile_web_app_capable',
        'field' => [
          'display' => __('statamic-metatags::apple.apple_mobile_web_app_capable'),
          'instructions' => __('statamic-metatags::apple.apple_mobile_web_app_capable_instructions'),
          'type' => 'text',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'apple_apple_mobile_web_app_status_bar_style',
        'field' => [
          'display' => __('statamic-metatags::apple.apple_mobile_web_app_status_bar_style'),
          'instructions' => __('statamic-metatags::apple.apple_mobile_web_app_status_bar_style_instructions'),
          'options' => [
            'default' => 'Default',
            'black' => 'Black',
            'black-translucent' => 'Black (translucent)',
          ],
          'type' => 'select',
          'clearable' => true,
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function android(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'android',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.android'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'android_theme_color',
        'field' => [
          'display' => __('statamic-metatags::android.theme_color'),
          'instructions' => __('statamic-metatags::android.theme_color_instructions'),
          'type' => 'color',
          'theme' => 'nano',
          'lock_opacity' => true,
          'default_color_mode' => 'HEXA',
          'color_modes' => ['HEX'],
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'android_manifest',
        'field' => [
          'display' => __('statamic-metatags::android.manifest'),
          'instructions' => __('statamic-metatags::android.manifest_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }

  protected function favicons(bool $localizable) {
    $this->fields = [
      [
        'handle' => 'favicons',
        'field' => [
          'display' => __('statamic-metatags::fieldsets.favicons'),
          'type' => 'section',
        ]
      ],
      [
        'handle' => 'favicons_mask_icon',
        'field' => [
          'display' => __('statamic-metatags::favicons.mask_icon'),
          'instructions' => __('statamic-metatags::favicons.mask_icon_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'width' => 66,
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'favicons_mask_icon_color',
        'field' => [
          'display' => __('statamic-metatags::favicons.mask_icon_color'),
          'instructions' => __('statamic-metatags::favicons.mask_icon_color_instructions'),
          'type' => 'color',
          'theme' => 'nano',
          'lock_opacity' => true,
          'default_color_mode' => 'HEXA',
          'color_modes' => ['HEX'],
          'width' => 33,
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'favicons_apple_touch_icon',
        'field' => [
          'display' => __('statamic-metatags::favicons.apple_touch_icon'),
          'instructions' => __('statamic-metatags::favicons.apple_touch_icon_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'favicons_icon_16',
        'field' => [
          'display' => __('statamic-metatags::favicons.icon_16'),
          'instructions' => __('statamic-metatags::favicons.icon_16_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
      [
        'handle' => 'favicons_icon_32',
        'field' => [
          'display' => __('statamic-metatags::favicons.icon_32'),
          'instructions' => __('statamic-metatags::favicons.icon_32_instructions'),
          'mode' => 'list',
          'container' => 'assets',
          'restrict' => false,
          'allow_uploads' => true,
          'max_files' => 1,
          'type' => 'assets',
          'localizable' => $localizable,
        ]
      ],
    ];

    return $this;
  }
}
