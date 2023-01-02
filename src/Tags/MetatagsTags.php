<?php


namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\DefaultMetatags;
use Gioppy\StatamicMetatags\Settings;
use Illuminate\Support\Str;
use Statamic\Facades\Asset;
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

    // Get page metatags and remove null values
    $pageFields = $page->filter(function ($item, $key) use ($settingsMeta) {
      return Str::startsWith($key, $settingsMeta);
    })
      ->filter()
      ->filter(function ($item) {
        if (is_array($item) && array_key_exists('value', $item) && $item['value'] === null) {
          return false;
        }

        return true;
      })
      ->all();

    // Merge default values with page metatags
    $fields = collect($defaultValues)
      ->filter()
      ->merge($pageFields)
      ->map(function ($field, $key) {
        // Filed with media
        if (Str::endsWith($key, ['image', 'video', 'audio'])) {
          // Default value, it seems that media value from default settings will be a simple string array...
          if (is_array($field) && array_key_exists(0, $field)) {
            return collect($field)->map(function ($item) {
              return is_array($item) ?
                new Value($item) :
                new Value(Asset::findByUrl($this->assetContainerPath($item)));
            })->toArray();
          }

          // ...otherwise, value from field inside a collection is an Asset!
          if (is_array($field) && array_key_exists('path', $field)) {
            return new Value($field);
          }

          return new Value(Asset::findByUrl($this->assetContainerPath($field)));
        }

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

  private function assetContainerPath($asset) {
    $settings = Settings::make();
    $containerPath = $settings->excludedMeta()['image_asset_container'];
    return "$containerPath/$asset";
  }
}
