<?php

namespace interactivesolutions\honeycombseo\app\models;

use interactivesolutions\honeycombcore\models\HCUuidModel;
use interactivesolutions\honeycombcore\models\traits\CustomAppends;
use interactivesolutions\honeycombseo\app\models\seo\HCSeoValues;

class HCSeo extends HCUuidModel
{
    use CustomAppends;

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

    /**
     * Values url
     *
     * @return string
     */
    public function getValuesUrlAttribute()
    {
        return route('admin.routes.seo.{_id}.values.index', $this->id);
    }

    /**
     * Seo values
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(HCSeoValues::class, 'record_id', 'id');
    }
}