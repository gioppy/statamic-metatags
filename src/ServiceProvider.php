<?php

namespace Gioppy\StatamicMetatags\Services;

use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $tags = [
        Tags\MetatagsTags::class,
    ];

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    public function boot()
    {
        parent::boot();

        $this->bootAddonNav();
    }

    protected function bootAddonNav()
    {
        Permission::group('metatags', 'Metatags', function () {
        });

        Permission::extend(function () {
            Permission::register('manage metatags settings')
                ->label('Manage Metatags Settings')
                ->group('metatags')
                ->description('Manage preferences of Metatags');
        });

        Nav::extend(function ($nav) {
            $nav->content('Meta tags')
                ->route('metatags.index')
                ->icon('angle-brackets-dots')
                ->can('manage metatags settings')
                ->children([
                    'Settings' => cp_route('metatags.settings'),
                    'Defaults' => cp_route('metatags.defaults'),
                ]);
        });

        return $this;
    }
}
