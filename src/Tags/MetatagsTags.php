<?php


namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\DefaultMetatags;
use Gioppy\StatamicMetatags\Settings;
use Illuminate\Support\Str;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Text;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class MetatagsTags extends Tags {

  protected static $handle = 'metatags';

  public function index() {
    $settings = Settings::make();

    $settingsMeta = $settings->onlyMeta();
    $settingsDefault = $settings->excludedMeta();

    $defaultValues = Arr::removeNullValues(DefaultMetatags::make()->augmented());

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
      ->merge($pageFields);

    // Check if fields have title, otherwise load default title
    if (array_key_exists('basic_title', $fields->all()) && !is_string($fields->only('basic_title')->all()['basic_title'])) {
      $defaultTitle = $page->only('title')->all();
      $fields->prepend(new Value($defaultTitle['title'] ?? ' '), 'basic_title');
    }

    // If there is no basic_title, load page title
    if (!array_key_exists('basic_title', $fields->all())) {
      $defaultTitle = $page->only('title')->all();
      $fields->prepend(new Value($defaultTitle['title'] ?? ' ', 'basic_title', new Text()), 'basic_title');
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
