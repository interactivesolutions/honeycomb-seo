<?php

namespace interactivesolutions\honeycombseo\app\providers;

use interactivesolutions\honeycombcore\providers\HCBaseServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Routing\Router;
use interactivesolutions\honeycombseo\app\models\HCSeo;
use interactivesolutions\honeycombseo\app\models\observers\SeoValuesObserver;

class HCSeoServiceProvider extends HCBaseServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycombseo\app\http\controllers';

    public $serviceProviderNameSpace = 'HCSeo';

    public function boot(Gate $gate, Router $router)
    {
        parent::boot($gate, $router);

        // register observer for eloquent model events
        HCSeo::observe(SeoValuesObserver::class);
    }
}





