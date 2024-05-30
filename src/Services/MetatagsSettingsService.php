<?php


namespace Gioppy\StatamicMetatags\Services;


use Illuminate\Support\Collection;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\YAML;

class MetatagsSettingsService
{

    /**
     * @var array|Collection|null
     */
    private mixed $items;

    private string|null $innerPath;

    public function __construct(mixed $items = null, string|null $path = null)
    {
        if (!is_null($items)) {
            $items = collect($items)->all();
        }

        $this->innerPath = $path;

        $this->items = $items;
    }

    public static function make(mixed $items = null, string|null $path = null): self
    {
        return new static($items, $path);
    }

    public function save(): void
    {
        File::put($this->path(), Yaml::dump($this->items));
    }

    public function values(): array
    {
        if (!is_null($this->innerPath)) {
            return Yaml::file($this->path())->parse();
        }

        return collect(Yaml::file(__DIR__ . '/../resources/content/metatags.yaml')->parse())
            ->merge(Yaml::file($this->path())->parse())
            ->all();
    }

    public function excludedMeta(): array
    {
        return collect(Yaml::file($this->path())->parse())
            ->only(['site_name', 'site_name_separator', 'image_asset_container'])
            ->all();
    }

    public function onlyMeta(): array
    {
        return collect(Yaml::file(__DIR__ . '/../resources/content/metatags.yaml')->parse())
            ->merge(Yaml::file($this->path())->parse())
            ->except(['site_name', 'site_name_separator'])
            ->collapse()
            ->all();
    }

    public function settingsForBlueprint()
    {
        return Blueprint::make()
            ->setContents([
                'sections' => [
                    'meta' => [
                        'display' => __('Metatags'),
                        'fields' => [
                            [
                                'handle' => 'meta_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:meta_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:meta_section:instructions'),
                                    'type' => 'section'
                                ]
                            ],
                            [
                                'handle' => 'basics',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:basics'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:basics:instructions'),
                                    'options' => [
                                        'basic' => 'Basic Meta tags',
                                        'advanced' => 'Advanced Meta tags',
                                    ],
                                ],
                            ],
                            [
                                'handle' => 'dublin_core_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:dublin_core'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:dublin_core_section:instructions'),
                                    'type' => 'section',
                                ],
                            ],
                            [
                                'handle' => 'dublin_core',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:dublin_core'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:dublin_core:instructions'),
                                    'options' => [
                                        'dublin_core' => 'Dublin Core',
                                        'dublin_core_advanced' => 'Dublin core advanced tags',
                                    ],
                                ],
                            ],
                            [
                                'handle' => 'facebook_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:facebook_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:facebook_section:instructions'),
                                    'type' => 'section',
                                ],
                            ],
                            [
                                'handle' => 'facebook',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:facebook'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:facebook:instructions'),
                                    'options' => [
                                        'og' => 'Open Graph',
                                        'facebook' => 'Facebook App',
                                    ],
                                ],
                            ],
                            [
                                'handle' => 'social_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:social_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:social_section:instructions'),
                                    'type' => 'section',
                                ],
                            ],
                            [
                                'handle' => 'social',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:social'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:social:instructions'),
                                    'options' => [
                                        'twitter' => 'Twitter',
                                        'pinterest' => 'Pinterest',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    private function path(): string
    {
        if (!is_null($this->innerPath)) {
            return base_path("content/metatags/settings/{$this->innerPath}.yaml");
        }

        return base_path('content/metatags/settings.yaml');
    }
}
