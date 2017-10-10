<?php

namespace interactivesolutions\honeycombseo\app\models\observers;

use interactivesolutions\honeycombseo\app\models\HCSeo;

class SeoValuesObserver
{
    /**
     * Listen to the User deleting event.
     *
     * @param HCSeo $seo
     * @return void
     */
    public function deleting(HCSeo $seo)
    {
        \Cache::forget('seo__' . $seo->path);
    }

    /**
     * Listen to the Seo saved event.
     *
     * @param HCSeo $seo
     * @return void
     */
    public function saved(HCSeo $seo)
    {
        \Cache::forget('seo__' . $seo->path);
    }
}