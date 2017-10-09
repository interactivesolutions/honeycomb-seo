<?php

namespace interactivesolutions\honeycombseo\app\providers;

use interactivesolutions\honeycombcore\providers\HCBaseServiceProvider;

class HCSeoServiceProvider extends HCBaseServiceProvider
{
    protected $homeDirectory = __DIR__;

    protected $commands = [];

    protected $namespace = 'interactivesolutions\honeycombseo\app\http\controllers';

    public $serviceProviderNameSpace = 'HCSeo';
}





