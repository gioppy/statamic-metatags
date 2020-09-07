<?php


namespace Gioppy\StatamicMetatags;


use Illuminate\Support\Collection;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Facades\Blueprint;

class DefaultMetatags {

  /**
   * @var array|Collection|null
   */
  private $items;

  public function __construct($items = null) {
    if (!is_null($items)) {
      $items = collect($items)->all();
    }

    $this->items = $items;
  }

  public static function make($items = null) {
    return new static($items);
  }

  public function augmented() {
    return Blueprint::make()
      ->setContents(['fields' => Metatags::make()->features()])
      ->fields()
      ->addValues($this->values())
      ->augment()
      ->values()
      ->all();
  }

  public function save() {
    File::put($this->path(), Yaml::dump($this->items));
  }

  public function values() {
    return Yaml::file($this->path())->parse();
  }

  private function path() {
    return base_path('content/metatags/default.yaml');
  }
}
