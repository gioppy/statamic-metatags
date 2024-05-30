<?php

namespace Gioppy\StatamicMetatags\Tags;


use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Statamic\Tags\Context;
use Statamic\Tags\Tags;

class MetatagsTags extends Tags
{

    protected static $handle = 'metatags';

    public function index()
    {
        //
    }

    public function basic(): \Illuminate\Contracts\View\View
    {
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

    public function googleSearch(): \Illuminate\Contracts\View\View
    {
        return view('statamic-metatags::google_search');
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
