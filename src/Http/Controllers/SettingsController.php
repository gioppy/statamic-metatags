<?php

namespace Gioppy\StatamicMetatags\Services\Http\Controllers;

use Gioppy\StatamicMetatags\Services\Metatags;
use Gioppy\StatamicMetatags\Services\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Statamic\Facades\AssetContainer;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Fieldset;
use Statamic\Support\Arr;

class SettingsController extends Controller
{

    public function edit()
    {
        $blueprint = $this->blueprint();
        $fields = $blueprint->fields()
            ->addValues(Settings::make()->values())
            ->preProcess();

        return view('statamic-metatags::settings.edit', [
            'title' => __('Settings'),
            'action' => cp_route('metatags.settings.update'),
            'blueprint' => $blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function update(Request $request)
    {
        $blueprint = $this->blueprint();
        $fields = $blueprint->fields()
            ->addValues($request->all());

        $fields->validate();

        $values = Arr::removeNullValues($fields->process()->values()->all());

        Settings::make($values)->save();

        Fieldset::make('metatags')->setContents([
            'title' => 'metatags',
            'fields' => Metatags::make()->features()
        ])->save();
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
                'sections' => [
                    'general' => [
                        'display' => __('General'),
                        'fields' => [
                            [
                                'handle' => 'site_name',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.general:site_name'),
                                    'instructions' => __('statamic-metatags::fieldsets.general:site_name:instructions'),
                                    'type' => 'text',
                                    'width' => 50,
                                ]
                            ],
                            [
                                'handle' => 'site_name_separator',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.general:site_name_separator'),
                                    'instructions' => __('statamic-metatags::fieldsets.general:site_name_separator:instructions'),
                                    'type' => 'text',
                                    'width' => 50,
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
                                    'options' => $assetContainersOptions
                                ]
                            ],
                        ]
                    ],
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
                                        'site_verifications' => 'Site verifications',
                                    ],
                                    'default' => [
                                        'basic'
                                    ]
                                ]
                            ],
                            [
                                'handle' => 'dublin_core_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:dublin_core'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:dublin_core_section:instructions'),
                                    'type' => 'section'
                                ]
                            ],
                            [
                                'handle' => 'dublin_core',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:dublin_core'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:dublin_core:instructions'),
                                    'options' => [
                                        'dublin_core' => 'Dublin Core',
                                        'dublin_core_advanced' => 'Dublin core advanced tags'
                                    ]
                                ]
                            ],
                            [
                                'handle' => 'google_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:google_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:google_section:instructions'),
                                    'type' => 'section'
                                ]
                            ],
                            [
                                'handle' => 'google',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:google'),
                                    'type' => 'checkboxes',
                                    'instructions' => __('statamic-metatags::fieldsets.meta:google:instructions'),
                                    'options' => [
                                        'google_plus' => 'Google +',
                                        'google_cse' => 'Google Custom Search Engine',
                                    ]
                                ]
                            ],
                            [
                                'handle' => 'facebook_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:facebook_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:facebook_section:instructions'),
                                    'type' => 'section'
                                ]
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
                                    ]
                                ]
                            ],
                            [
                                'handle' => 'social_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:social_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:social_section:instructions'),
                                    'type' => 'section'
                                ]
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
                                    ]
                                ]
                            ],
                            [
                                'handle' => 'other_section',
                                'field' => [
                                    'display' => __('statamic-metatags::fieldsets.meta:other_section'),
                                    'instructions' => __('statamic-metatags::fieldsets.meta:other_section:instructions'),
                                    'type' => 'section'
                                ]
                            ],
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
                                    ]
                                ]
                            ],
                        ]
                    ],
                ]
            ]);
    }
}
