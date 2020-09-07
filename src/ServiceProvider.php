<?php

namespace Gioppy\StatamicMetatags;

use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider {

  protected $tags = [
    Tags\MetatagsTags::class,
  ];

  protected $fieldtypes = [
    Fieldtypes\MetatagsFieldtype::class,
  ];

  protected $scripts = [
    __DIR__ . '/../resources/dist/js/cp.js',
  ];

  protected $routes = [
    'cp' => __DIR__ . '/../routes/cp.php',
  ];

  public function boot() {
    parent::boot();

    $this->bootAddonNav();
  }

  protected function bootAddonNav() {
    Nav::extend(function ($nav) {
      $nav->tools('Meta tags')
        ->route('metatags.index')
        ->icon('angle-brackets-dots')
        ->active('metatags')
        ->children([
          'Settings' => cp_route('metatags.settings'),
          'Defaults' => cp_route('metatags.defaults'),
        ]);
    });

    return $this;
  }
}
