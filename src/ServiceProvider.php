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
                ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M20 12V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H11M8 10h8M8 6h4m-4 8h3m9.5 6.5L22 22"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15 18a3 3 0 1 0 6 0 3 3 0 0 0-6 0"/><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16 5.4V2.354a.354.354 0 0 1 .604-.25l3.292 3.292a.353.353 0 0 1-.25.604H16.6a.6.6 0 0 1-.6-.6"/></svg>')
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
