<?php

namespace Gioppy\StatamicMetatags\Listeners;

use Gioppy\StatamicMetatags\Services\MetatagsService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Statamic\Events\TermBlueprintFound;
use Statamic\Fields\Blueprint;
use Statamic\Support\Str;
use Statamic\Taxonomies\Term;

class TermBlueprintFoundListener
{
    public function __construct()
    {
    }

    public function handle(TermBlueprintFound $event): void
    {
        /** @var Blueprint $blueprint */
        $blueprint = $event->blueprint;

        // Load saved metatags blueprint for current entry
        $namespacePath = Str::replace('.', '/', $blueprint->namespace());
        $features = MetatagsSettingsService::make(null, "{$namespacePath}/{$blueprint->handle()}")
            ->onlyMeta();

        $content = $blueprint->contents();
        $content['tabs']['seo'] = [
            'display' => __('SEO'),
            'sections' => MetatagsService::make()->forFeatures($features),
        ];

        $event->blueprint->setContents($content);

        /** @var Term $term */
        $term = $event->term;
        if (!is_null($term)) {
            $event->blueprint->setParent($event->blueprint);
        }
    }
}
