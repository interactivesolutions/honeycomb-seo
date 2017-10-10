<?php

namespace interactivesolutions\honeycombseo\app\models\seo;

use interactivesolutions\honeycombcore\models\HCUuidModel;
use interactivesolutions\honeycombseo\app\models\HCSeo;

class HCSeoValues extends HCUuidModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hc_seo_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'record_id', 'type', 'name', 'content'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['record'];

    /**
     * Relation to record
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function record()
    {
        return $this->belongsTo(HCSeo::class, 'record_id', 'id');
    }
}