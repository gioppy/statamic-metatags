<?php

namespace Gioppy\StatamicMetatags\Repositories;

use Gioppy\StatamicMetatags\Contracts\MetaTagsRepository;
use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Statamic\Entries\Entry;
use Statamic\Facades\URL;
use Statamic\Fields\Blueprint;
use Statamic\Support\Str;
use Statamic\Taxonomies\Term;

class MetaTagsBlueprintRepository implements MetaTagsRepository
{

    public function entry(Blueprint $blueprint, Entry|null $entry): void
    {
        $content = $this->setSeoTab($blueprint->contents());
        $namespacePath = Str::replace('.', '/', $blueprint->namespace());

        if (Str::contains(URL::getCurrent(), 'entries') || !Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp'))) {
            $content = $this->setMetaTags("{$namespacePath}/{$blueprint->handle()}", $content);
        }

        if (!Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp')) && !is_null($entry)) {
            $content = $this->setValues($namespacePath, $blueprint, $entry, $content);
        }

        $blueprint->setContents($content);

        if (!is_null($entry)) {
            $blueprint->setParent($blueprint);
        }
    }

    public function term(Blueprint $blueprint, Term|null $term): void
    {
        $content = $this->setSeoTab($blueprint->contents());
        $namespacePath = Str::replace('.', '/', $blueprint->namespace());

        if (Str::contains(URL::getCurrent(), 'terms') || !Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp'))) {
            $content = $this->setMetaTags("{$namespacePath}/{$blueprint->handle()}", $content);
        }

        if (!Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp')) && !is_null($term)) {
            $content = $this->setValues($namespacePath, $blueprint, $term, $content);
        }

        $blueprint->setContents($content);

        if (!is_null($term)) {
            $blueprint->setParent($blueprint);
        }
    }

    /**
     * @param array $content
     * @return array
     */
    private function setSeoTab(array $content): array
    {
        $content['tabs']['seo'] = [
            'display' => __('SEO'),
            'sections' => [],
        ];

        return $content;
    }

    /**
     * @param string $path
     * @param array $content
     * @return array
     */
    private function setMetaTags(string $path, array $content): array
    {
        // Load saved metatags blueprint for current entry
        $features = MetatagsSettingsService::make(null, $path)->onlyMeta();

        $content['tabs']['seo'] = [
            ...$content['tabs']['seo'],
            'sections' => MetatagsService::make()->forFeatures($features),
        ];

        return $content;
    }

    /**
     * @param string $namespacePath
     * @param Blueprint $blueprint
     * @param Entry|Term $entry
     * @param array $content
     * @return array
     */
    private function setValues(string $namespacePath, Blueprint $blueprint, Entry|Term $entry, array $content): array
    {
        $commonFeatures = MetatagsSettingsService::make()->onlyMeta();

        $defaultValues = MetatagsDefaultService::make(null, "{$namespacePath}/{$blueprint->handle()}")
            ->values();
        $commonValues = MetatagsDefaultService::make()
            ->values();

        // Merge default values and common values on current entry
        $values = collect($defaultValues)
            ->merge($entry->values()->all())
            ->merge($commonValues);
        $entry->merge($values);

        // Handle title: if the entry does not have basic_title
        // set default title otherwise set content title
        if (is_null($entry->get('basic_title'))) {
            $entry->set('basic_title', $defaultValues['basic_title'] ?? $entry->get('title'));
        }

        $content['tabs']['seo'] = [
            ...$content['tabs']['seo'],
            'sections' => [
                ...$content['tabs']['seo']['sections'],
                ...MetatagsService::make()->forFeatures($commonFeatures)
            ],
        ];
        return $content;
    }
}