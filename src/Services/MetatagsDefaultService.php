<?php


namespace Gioppy\StatamicMetatags\Services;


use Illuminate\Support\Collection;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Facades\Blueprint;

class MetatagsDefaultService
{
    private array|Collection|null $items;

    private string|null $innerPath;

    public function __construct(array|Collection|null $items = null, ?string $path = null)
    {
        if (!is_null($items)) {
            $items = collect($items)->all();
        }

        $this->innerPath = $path;
        $this->items = $items;
    }

    public static function make(array|Collection|null $items = null, ?string $path = null): self
    {
        return new static($items, $path);
    }

    public function augmented()
    {
        return Blueprint::make()
            ->setContents(['fields' => MetatagsService::make()->features()])
            ->fields()
            ->addValues($this->values())
            ->augment()
            ->values()
            ->all();
    }

    public function save(): void
    {
        File::put($this->path(), Yaml::dump($this->items));
    }

    public function values(): array
    {
        return Yaml::file($this->path())->parse();
    }

    private function path(): string
    {
        if (!is_null($this->innerPath)) {
            return base_path("content/metatags/default/{$this->innerPath}.yaml");
        }

        return base_path('content/metatags/default.yaml');
    }
}
