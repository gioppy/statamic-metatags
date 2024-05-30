<?php

namespace Gioppy\StatamicMetatags\Listeners;

use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Statamic\Entries\Entry;
use Statamic\Events\EntryBlueprintFound;
use Statamic\Facades\URL;
use Statamic\Fields\Blueprint;
use Statamic\Support\Str;

class EntryBlueprintFoundListener
{
    public function __construct()
    {
    }

    public function handle(EntryBlueprintFound $event): void
    {
        /** @var Blueprint $blueprint */
        $blueprint = $event->blueprint;
        $content = $blueprint->contents();
        $namespacePath = Str::replace('.', '/', $blueprint->namespace());

        /** @var Entry $entry */
        $entry = $event->entry;

        if (Str::contains(URL::getCurrent(), 'entries') || !Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp'))) {
            // Load saved metatags blueprint for current entry
            $features = MetatagsSettingsService::make(null, "{$namespacePath}/{$blueprint->handle()}")
                ->onlyMeta();

            $content['tabs']['seo'] = [
                'display' => __('SEO'),
                'sections' => MetatagsService::make()->forFeatures($features),
            ];
        }

        if (!Str::contains(URL::getCurrent(), config('statamic.cp.route', 'cp'))) {
            $commonFeatures = MetatagsSettingsService::make()->onlyMeta();

            $defaultValues = MetatagsDefaultService::make(null, "{$namespacePath}/{$blueprint->handle()}")->values();
            $commonValues = MetatagsDefaultService::make()->values();

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

            if (array_key_exists('seo', $content['tabs'])) {
                $content['tabs']['seo'] = [
                    'display' => __('SEO'),
                    'sections' => [],
                ];
            }

            $content['tabs']['seo'] = [
                'display' => __('SEO'),
                'sections' => [
                    ...$content['tabs']['seo']['sections'],
                    ...MetatagsService::make()->forFeatures($commonFeatures)
                ],
            ];
        }

        $event->blueprint->setContents($content);

        if (!is_null($entry)) {
            $event->blueprint->setParent($event->blueprint);
        }
    }
}
