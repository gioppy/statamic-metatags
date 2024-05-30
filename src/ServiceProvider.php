<?php

namespace Gioppy\StatamicMetatags;

use Gioppy\StatamicMetatags\Contracts\MetaTagsRepository;
use Gioppy\StatamicMetatags\Listeners\EntryBlueprintFoundListener;
use Gioppy\StatamicMetatags\Listeners\TermBlueprintFoundListener;
use Gioppy\StatamicMetatags\Repositories\MetaTagsBlueprintRepository;
use Statamic\Events\EntryBlueprintFound;
use Statamic\Events\TermBlueprintFound;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $tags = [
        Tags\MetatagsTags::class,
    ];

    protected $listen = [
        EntryBlueprintFound::class => [
            EntryBlueprintFoundListener::class,
        ],
        TermBlueprintFound::class => [
            TermBlueprintFoundListener::class,
        ],
    ];

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    public function boot(): void
    {
        parent::boot();

        $this->bootAddonNav();
    }

    protected function bootAddonNav(): self
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
                    'Blueprints' => cp_route('metatags.blueprints'),
                ]);
        });

        return $this;
    }

    public function register(): void
    {
        $this->app->bind(MetaTagsRepository::class, fn($app) => new MetaTagsBlueprintRepository());
    }
}
