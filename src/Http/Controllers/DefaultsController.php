<?php


namespace Gioppy\StatamicMetatags\Http\Controllers;


use Gioppy\StatamicMetatags\Services\MetatagsDefaultService;
use Gioppy\StatamicMetatags\Services\MetatagsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Statamic\Facades\Blueprint;
use Statamic\Support\Arr;

class DefaultsController extends Controller
{

    public function edit()
    {
        $blueprint = $this->blueprint();
        $fields = $blueprint->fields()
            ->addValues(MetatagsDefaultService::make()->values())
            ->preProcess();

        return view('statamic-metatags::defaults.edit', [
            'title' => __('Defaults'),
            'action' => cp_route('metatags.defaults.update'),
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
