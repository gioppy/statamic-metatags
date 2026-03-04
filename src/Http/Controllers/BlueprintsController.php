<?php

namespace Gioppy\StatamicMetatags\Http\Controllers;

use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Illuminate\Http\Request;
use Statamic\CP\PublishForm;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Support\Str;

class BlueprintsController extends CpController
{
    public function index()
    {
        $collectionItems = Collection::all()
            ->map(fn(\Statamic\Entries\Collection $collection) => $collection->entryBlueprints())
            ->flatten(1)
            ->filter(fn(\Statamic\Fields\Blueprint $blueprint) => !Str::contains($blueprint->initialPath(), 'default.yaml'))
            ->map(function (\Statamic\Fields\Blueprint $blueprint) {
                $namespace = explode('.', $blueprint->namespace());
                $settings = MetatagsSettingsService::make(null, "{$namespace[0]}/{$namespace[1]}/{$blueprint->handle()}")->onlyMeta();

                return [
                    "id" => $blueprint->namespace(),
                    "empty" => count($settings) === 0,
                    "type" => $namespace[0],
                    "entity" => $namespace[1],
                    "name" => $blueprint->handle(),
                    "label" => $blueprint->title(),
                ];
            });

        $collectionColumns = [
            [
                'field' => 'entity',
                'label' => __('Collection'),
                'sortable' => true,
            ],
            [
                'field' => 'label',
                'label' => __('Label'),
                'sortable' => true,
            ],
        ];

        $taxonomiesItems = Taxonomy::all()
            ->map(fn(\Statamic\Taxonomies\Taxonomy $taxonomy) => $taxonomy->termBlueprint())
            ->filter(fn(\Statamic\Fields\Blueprint $blueprint) => !Str::contains($blueprint->initialPath(), 'default.yaml'))
            ->map(function (\Statamic\Fields\Blueprint $blueprint) {
                $namespace = explode('.', $blueprint->namespace());
                $settings = MetatagsSettingsService::make(null, "{$namespace[0]}/{$namespace[1]}/{$blueprint->handle()}")->onlyMeta();

                return [
                    "id" => $blueprint->namespace(),
                    "empty" => count($settings) === 0,
                    "type" => $namespace[0],
                    "entity" => $namespace[1],
                    "name" => $blueprint->handle(),
                    "label" => $blueprint->title(),
                ];
            });

        $taxonomiesColumns = [
            [
                'field' => 'entity',
                'label' => __('Taxonomy'),
                'sortable' => true,
            ],
            [
                'field' => 'label',
                'label' => __('Label'),
                'sortable' => true,
            ],
        ];

        return view('statamic-metatags::blueprints.index', [
            'collectionItems' => $collectionItems,
            'collectionColumns' => $collectionColumns,
            'taxonomiesItems' => $taxonomiesItems,
            'taxonomiesColumns' => $taxonomiesColumns,
        ]);
    }

    public function editSettings(string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";
        $blueprint = Blueprint::find("$type.$entity.$name");

        return PublishForm::make(MetatagsSettingsService::make(null, $path)->settingsForBlueprint())
            ->title(__('Metatags settings for :name blueprint', ['name' => $blueprint->title()]))
            ->icon('setting-cog-gear')
            ->values(MetatagsSettingsService::make(null, $path)->values())
            ->submittingTo(cp_route('metatags.blueprints.updateSettings', ['type' => $type, 'entity' => $entity, 'name' => $name]));
    }

    public function editDefaults(string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";
        $systemBlueprint = Blueprint::find("$type.$entity.$name");

        // Load default active settings for current blueprint
        $features = MetatagsSettingsService::make(null, $path)->onlyMeta();

        return PublishForm::make($this->blueprint($features))
            ->title(__('Default values for :name blueprint', ['name' => $systemBlueprint->title()]))
            ->icon('forms')
            ->values(MetatagsDefaultService::make(null, $path)->values())
            ->submittingTo(cp_route('metatags.blueprints.updateDefaults', ['type' => $type, 'entity' => $entity, 'name' => $name]));
    }

    public function updateSettings(Request $request, string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";

        $values = PublishForm::make(MetatagsSettingsService::make(null, $path)->settingsForBlueprint())
            ->submit($request->all());

        MetatagsSettingsService::make($values, $path)->save();
    }

    public function updateDefaults(Request $request, string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";

        $features = MetatagsSettingsService::make(null, $path)->onlyMeta();

        $values = PublishForm::make($this->blueprint($features))
            ->submit($request->all());

        MetatagsDefaultService::make($values, $path)->save();
    }

    private function blueprint(array $features)
    {
        return Blueprint::make()
            ->setContents([
                'tabs' => [
                    'main' => [
                        'display' => __('Main'),
                        'sections' => MetatagsService::make()->forFeatures($features),
                    ],
                ],
            ]);
    }
}
