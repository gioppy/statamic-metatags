<?php


namespace Gioppy\StatamicMetatags\Http\Controllers;


use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Statamic\CP\PublishForm;
use Statamic\Facades\Blueprint;

class DefaultsController extends Controller
{

    public function edit()
    {
        return PublishForm::make($this->blueprint())
            ->title(__('Defaults'))
            ->icon('forms')
            ->values(MetatagsDefaultService::make()->values())
            ->submittingTo(cp_route('metatags.defaults.update'));
    }

    public function update(Request $request)
    {
        $values = PublishForm::make($this->blueprint())
            ->submit($request->all());

        MetatagsDefaultService::make($values)->save();
    }

    private function blueprint()
    {
        return Blueprint::make()
            ->setContents([
                'tabs' => [
                    'main' => [
                        'display' => __('Main'),
                        'sections' => MetatagsService::make()->features()
                    ],
                ],
            ]);
    }
}
