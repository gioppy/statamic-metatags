<?php

namespace Gioppy\StatamicMetatags\Http\Controllers;

use Gioppy\StatamicMetatags\Services\MetatagsSettingsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Statamic\CP\PublishForm;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint;

class SettingsController extends Controller
{

    public function edit()
    {
        return PublishForm::make($this->blueprint())
            ->values(MetatagsSettingsService::make()->values())
            ->title(__('Common Settings'))
            ->icon('setting-cog-gear')
            ->submittingTo(cp_route('metatags.settings.update'));
    }

    public function update(Request $request)
    {
        $values = PublishForm::make($this->blueprint())
            ->submit($request->all());

        MetatagsSettingsService::make($values)->save();
    }

    private function blueprint()
    {
        /**
         * @var $assetContainers \Illuminate\Support\Collection
         */
        $assetContainers = AssetContainer::all();
        $assetContainersOptions = $assetContainers->mapWithKeys(function (\Statamic\Assets\AssetContainer $item) {
            return [$item->url() => $item->title()];
        })
            ->toArray();

        return Blueprint::make()
            ->setContents([
                'tabs' => [
                    'general' => [
                        'display' => __('General'),
                        'sections' => [
                            [
                                'fields' => [
                                    [
                                        'handle' => 'site_name',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.general:site_name'),
                                            'instructions' => __('statamic-metatags::fieldsets.general:site_name:instructions'),
                                            'type' => 'text',
                                            'width' => 50,
                                            'listable' => false,
                                            'validate' => [
                                                'required',
                                            ],
                                        ]
                                    ],
                                    [
                                        'handle' => 'site_name_separator',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.general:site_name_separator'),
                                            'instructions' => __('statamic-metatags::fieldsets.general:site_name_separator:instructions'),
                                            'type' => 'text',
                                            'width' => 50,
                                            'listable' => false,
                                        ]
                                    ],
                                    [
                                        'handle' => 'image_asset_container',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.general:image_asset_container'),
                                            'instructions' => __('statamic-metatags::fieldsets.general:image_asset_container:instructions'),
                                            'type' => 'select',
                                            'multiple' => false,
                                            'clearable' => false,
                                            'searchable' => true,
                                            'push_tags' => false,
                                            'cast_booleans' => false,
                                            'options' => $assetContainersOptions,
                                            'listable' => false,
                                            'validate' => [
                                                'required',
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'meta' => [
                        'display' => __('Metatags'),
                        'sections' => [
                            [
                                'display' => __('statamic-metatags::fieldsets.meta:meta_section'),
                                'instructions' => __('statamic-metatags::fieldsets.meta:meta_section:instructions'),
                                'fields' => [
                                    [
                                        'handle' => 'basics',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.meta:basics'),
                                            'type' => 'checkboxes',
                                            'instructions' => __('statamic-metatags::fieldsets.meta:basics:instructions'),
                                            'options' => [
                                                'site_verifications' => 'Site verifications',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'display' => __('statamic-metatags::fieldsets.meta:google_section'),
                                'instructions' => __('statamic-metatags::fieldsets.meta:google_section:instructions'),
                                'fields' => [
                                    [
                                        'handle' => 'google',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.meta:google'),
                                            'type' => 'checkboxes',
                                            'instructions' => __('statamic-metatags::fieldsets.meta:google:instructions'),
                                            'options' => [
                                                'google_search' => 'Google Search',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'display' => __('statamic-metatags::fieldsets.meta:other_section'),
                                'instructions' => __('statamic-metatags::fieldsets.meta:other_section:instructions'),
                                'fields' => [
                                    [
                                        'handle' => 'other',
                                        'field' => [
                                            'display' => __('statamic-metatags::fieldsets.meta:other'),
                                            'type' => 'checkboxes',
                                            'instructions' => __('statamic-metatags::fieldsets.meta:other:instructions'),
                                            'options' => [
                                                'app_links' => 'App links',
                                                'mobile' => 'Mobile & UI',
                                                'apple' => 'Apple proprietary',
                                                'android' => 'Android proprietary',
                                                'favicons' => 'Favicons',
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ],
                    ],
                ],
            ]);
    }
}
