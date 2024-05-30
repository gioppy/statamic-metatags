<?php

namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Illuminate\Support\Str;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Text;
use Statamic\Support\Arr;
use Statamic\Tags\Context;
use Statamic\Tags\Tags;

class MetatagsTags extends Tags
{

    protected static $handle = 'metatags';

    public function index()
    {
        /*$context = $this->context;
        $settings = MetatagsSettingsService::make();

        $settingsMeta = $settings->onlyMeta();
        $settingsDefault = $settings->excludedMeta();

        $defaultValues = Arr::removeNullValues(MetatagsDefaultService::make()->augmented());

        // Get page metatags and remove null values
        $pageFields = $this->context->filter(function ($item, $key) use ($settingsMeta) {
            return Str::startsWith($key, $settingsMeta);
        })
            ->filter()
            ->filter(function ($item) {
                if (is_array($item) && array_key_exists('value', $item) && $item['value'] === null) {
                    return false;
                }

                return true;
            })
            ->all();

        // Merge default values with page metatags
        $fields = collect($defaultValues)
            ->filter()
            ->merge($pageFields);

        // Check if fields have title, otherwise load default title
        if (array_key_exists('basic_title', $fields->all()) && !is_string($fields->get('basic_title')->value())) {
            $defaultTitle = $this->context->only('title')->all();
            $fields->prepend(new Value($defaultTitle['title'] ?? ' '), 'basic_title');
        }

        // If there is no basic_title, load page title
        if (!array_key_exists('basic_title', $fields->all())) {
            $defaultTitle = $this->context->only('title')->all();
            $fields->prepend(new Value($defaultTitle['title'] ?? ' ', 'basic_title', new Text()), 'basic_title');
        }

        return view('statamic-metatags::metatags', [
            'fields' => $fields->all(),
            'settings' => $settingsMeta,
            'extras' => [
                'site_name' => $settingsDefault['site_name'],
                'site_name_separator' => $settingsDefault['site_name_separator'],
                'permalink' => $this->context->get('permalink'),
            ],
        ]);*/
    }

    public function basic(): \Illuminate\Contracts\View\View
    {
        // TODO: check title for correct value

        $settings = MetatagsSettingsService::make();
        $settingsDefault = $settings->excludedMeta();

        return view('statamic-metatags::basic', [
            'extras' => [
                'site_name' => $settingsDefault['site_name'],
                'site_name_separator' => $settingsDefault['site_name_separator'],
            ],
        ]);
    }

    public function advanced(): \Illuminate\Contracts\View\View
    {
        /** @var Context $context */
        $context = $this->context;

        return view('statamic-metatags::advanced', [
            'extras' => [
                'permalink' => $this->context->get('permalink'),
            ],
        ]);
    }

    public function dublinCore(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::dublin_core');
    }

    public function dublinCoreAdvanced(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::dublin_core_advanced');
    }

    public function googlePlus(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::google_plus');
    }

    public function googleCse(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::google_cse');
    }

    public function opengraph(): \Illuminate\Contracts\View\View
    {
        /** @var Context $context */
        $context = $this->context;

        $settings = MetatagsSettingsService::make();
        $settingsDefault = $settings->excludedMeta();

        return view('statamic-metatags::opengraph', [
            'basic_title' => $context->get('basic_title'),
            'extras' => [
                'site_name' => $settingsDefault['site_name'],
            ],
        ]);
    }

    public function facebook(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::facebook');
    }

    public function twitter(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::twitter');
    }

    public function pinterest(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::pinterest');
    }

    public function siteVerifications(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::site_verifications');
    }

    public function appLinks(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::app_links');
    }

    public function mobile(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::mobile');
    }

    public function apple(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::apple');
    }

    public function android(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::android');
    }

    public function favicons(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::favicons');
    }
}
