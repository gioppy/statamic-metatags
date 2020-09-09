<?php


namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\DefaultMetatags;
use Gioppy\StatamicMetatags\Metatags;
use Gioppy\StatamicMetatags\Settings;
use Illuminate\Support\Str;
use Statamic\Facades\Blueprint;
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

    $fields = Arr::removeNullValues($page
      ->filter(function ($item, $key) use ($settingsMeta) {
        return Str::startsWith($key, $settingsMeta);
      })
      ->map(function (Value $field, $key) use ($defaultValues) {
        if (is_null($field->raw()) && array_key_exists($key, $defaultValues)) {
          return new Value($defaultValues[$key], $field->handle(), $field->fieldtype(), $field->augmentable());
        }
        return $field;
      })
      ->all());

    return view('statamic-metatags::metatags', [
      'fields' => $fields,
      'settings' => $settingsMeta,
      'extras' => [
        'site_name' => $settingsDefault['site_name'],
        'site_name_separator' => $settingsDefault['site_name_separator'],
        'permalink' => $page->get('permalink')
      ]
    ]);
  }
}
