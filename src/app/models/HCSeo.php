<?php

namespace interactivesolutions\honeycombseo\app\models;

use interactivesolutions\honeycombcore\models\HCUuidModel;

class HCSeo extends HCUuidModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_seo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'path'];
}