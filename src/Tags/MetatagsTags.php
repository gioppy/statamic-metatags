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
    $prefix = $this->params->get('prefix', 'mt');

    $settings = Settings::make()->onlyMeta();

    $defaultValues = Arr::removeNullValues(DefaultMetatags::make()->values());

    $page = collect($this->context->get('page'));

    $fields = Arr::removeNullValues($page
      ->filter(function ($item, $key) use ($settings) {
        return Str::startsWith($key, $settings);
      })
      ->map(function (Value $field, $key) use ($defaultValues) {
        if (is_null($field->raw()) && array_key_exists($key, $defaultValues)) {
          return new Value($defaultValues[$key], $field->handle(), $field->fieldtype(), $field->augmentable());
        }
        return $field;
      })
      ->all());

    //dump($fields);

    return view('statamic-metatags::metatags', [
      'fields' => $fields,
      'settings' => $settings,
      'extras' => [
        'site' => $this->context->get('site'),
        'permalink' => $page->get('permalink')
      ]
    ]);
  }
}
