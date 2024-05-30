<?php

namespace Gioppy\StatamicMetatags\Http\Controllers;

use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Illuminate\Http\Request;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Collection;
use Statamic\Facades\Taxonomy;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Support\Arr;
use Statamic\Support\Str;

class BlueprintsController extends CpController
{
    public function index()
    {
        $collections = Collection::all()
            ->map(fn(\Statamic\Entries\Collection $collection) => $collection->entryBlueprints())
            ->flatten(1)
            ->filter(fn(\Statamic\Fields\Blueprint $blueprint) => !Str::contains($blueprint->initialPath(), 'default.yaml'))
            ->map(function (\Statamic\Fields\Blueprint $blueprint) {
                $namespace = explode('.', $blueprint->namespace());
                $settings = MetatagsSettingsService::make(null, "{$namespace[0]}/{$namespace[1]}/{$blueprint->handle()}")->onlyMeta();

                return [
                    "empty" => count($settings) === 0,
                    "type" => $namespace[0],
                    "entity" => $namespace[1],
                    "name" => $blueprint->handle(),
                    "label" => $blueprint->title(),
                ];
            });

        $taxonomies = Taxonomy::all()
            ->map(fn(\Statamic\Taxonomies\Taxonomy $taxonomy) => $taxonomy->termBlueprint())
            ->filter(fn(\Statamic\Fields\Blueprint $blueprint) => !Str::contains($blueprint->initialPath(), 'default.yaml'))
            ->map(function (\Statamic\Fields\Blueprint $blueprint) {
                $namespace = explode('.', $blueprint->namespace());
                $settings = MetatagsSettingsService::make(null, "{$namespace[0]}/{$namespace[1]}/{$blueprint->handle()}")->onlyMeta();

                return [
                    "empty" => count($settings) === 0,
                    "type" => $namespace[0],
                    "entity" => $namespace[1],
                    "name" => $blueprint->handle(),
                    "label" => $blueprint->title(),
                ];
            });

        return view('statamic-metatags::blueprints.index', [
            'collections' => $collections,
            'taxonomies' => $taxonomies,
        ]);
    }

    public function editSettings(string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";
        $blueprint = Blueprint::find("$type.$entity.$name");

        $settings = MetatagsSettingsService::make(null, $path)->settingsForBlueprint();
        $fields = $settings->fields()
            ->addValues(MetatagsSettingsService::make(null, $path)->values())
            ->preProcess();

        return view('statamic-metatags::blueprints.settings.edit', [
            'type' => 'collection',
            'title' => __('Settings for :name blueprint', ['name' => $blueprint->title()]),
            'blueprint' => $settings->toPublishArray(),
            'action' => cp_route('metatags.blueprints.updateSettings', ['type' => $type, 'entity' => $entity, 'name' => $name]),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function editDefaults(string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";
        $systemBlueprint = Blueprint::find("$type.$entity.$name");

        // Load default active settings for current blueprint
        $features = MetatagsSettingsService::make(null, $path)->onlyMeta();

        // Build blueprint
        $blueprint = $this->blueprint($features);

        $fields = $blueprint->fields()
            ->addValues(MetatagsDefaultService::make(null, $path)->values())
            ->preProcess();

        return view('statamic-metatags::blueprints.defaults.edit', [
            'title' => __('Default values for :name blueprint', ['name' => $systemBlueprint->title()]),
            'action' => cp_route('metatags.blueprints.updateDefaults', ['type' => $type, 'entity' => $entity, 'name' => $name]),
            'blueprint' => $blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function updateSettings(Request $request, string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";
        $blueprint = MetatagsSettingsService::make(null, $path)->settingsForBlueprint();

        $fields = $blueprint->fields()
            ->addValues($request->all());

        $fields->validate();

        $values = Arr::removeNullValues($fields->process()->values()->all());

        MetatagsSettingsService::make($values, $path)->save();
    }

    public function updateDefaults(Request $request, string $type, string $entity, string $name)
    {
        $path = "$type/$entity/$name";

        $features = MetatagsSettingsService::make(null, $path)->onlyMeta();

        $blueprint = $this->blueprint($features);
        $fields = $blueprint->fields()
            ->addValues($request->all());

        $fields->validate();

        $values = Arr::removeNullValues($fields->process()->values()->all());

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
