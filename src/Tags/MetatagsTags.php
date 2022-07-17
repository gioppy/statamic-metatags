<?php


namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\DefaultMetatags;
use Gioppy\StatamicMetatags\Settings;
use Illuminate\Support\Str;
use Statamic\Fields\Value;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class MetatagsTags extends Tags {

  protected static $handle = 'metatags';

  public function index() {
    $settings = Settings::make();

    $settingsMeta = $settings->onlyMeta();
    $settingsDefault = $settings->excludedMeta();

    $defaultValues = Arr::removeNullValues(DefaultMetatags::make()->values());

    $page = collect($this->context->get('page'));

    $fields = $page->filter(function ($item, $key) use ($settingsMeta) {
      return Str::startsWith($key, $settingsMeta);
    })
      ->filter()
      ->merge($defaultValues)
      ->map(function ($field, $key) {
        // Field with single option
        if (is_array($field) && array_key_exists('value', $field) && !is_null($field['value'])) {
          return new Value($field['value']);
        }

        // Field with multiple options
        if (is_array($field) && Arr::isList($field)) {
          return new Value($field);
        }

        return new Value($field);
      });

    // Check if fields have title, otherwise load default title
    if (!array_key_exists('basic_title', $fields->all())) {
      $defaultTitle = $page->only('title')->all();
      $fields->prepend(new Value($defaultTitle['title']), 'basic_title');
    }

    return view('statamic-metatags::metatags', [
      'fields' => $fields->all(),
      'settings' => $settingsMeta,
      'extras' => [
        'site_name' => $settingsDefault['site_name'],
        'site_name_separator' => $settingsDefault['site_name_separator'],
        'permalink' => $page->get('permalink')
      ]
    ]);
  }
}
