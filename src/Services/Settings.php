<?php


namespace Gioppy\StatamicMetatags\Services;


use Illuminate\Support\Collection;
use Statamic\Facades\File;
use Statamic\Facades\YAML;

class Settings
{

    /**
     * @var array|Collection|null
     */
    private $items;

    public function __construct($items = null)
    {
        if (!is_null($items)) {
            $items = collect($items)->all();
        }

        $this->items = $items;
    }

    public static function make($items = null)
    {
        return new static($items);
    }

    public function save()
    {
        File::put($this->path(), Yaml::dump($this->items));
    }

    public function values()
    {
        return collect(Yaml::file(__DIR__ . '/../resources/content/metatags.yaml')->parse())
            ->merge(Yaml::file($this->path())->parse())
            ->all();
    }

    public function excludedMeta()
    {
        return collect(Yaml::file($this->path())->parse())
            ->only(['site_name', 'site_name_separator', 'image_asset_container'])
            ->all();
    }

    public function onlyMeta()
    {
        return collect(Yaml::file(__DIR__ . '/../resources/content/metatags.yaml')->parse())
            ->merge(Yaml::file($this->path())->parse())
            ->except(['site_name', 'site_name_separator'])
            ->collapse()
            ->all();
    }

    private function path()
    {
        return base_path('content/metatags/settings.yaml');
    }
}
