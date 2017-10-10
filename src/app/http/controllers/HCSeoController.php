<?php

namespace interactivesolutions\honeycombseo\app\http\controllers;

use Illuminate\Database\Eloquent\Builder;
use interactivesolutions\honeycombcore\http\controllers\HCBaseController;
use interactivesolutions\honeycombseo\app\models\HCSeo;
use interactivesolutions\honeycombseo\app\validators\HCSeoValidator;

class HCSeoController extends HCBaseController
{

    //TODO recordsPerPage setting

    /**
     * Returning configured admin view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex()
    {
        $config = [
            'title'       => trans('HCSeo::seo.page_title'),
            'listURL'     => route('admin.api.routes.seo'),
            'newFormUrl'  => route('admin.api.form-manager', ['seo-new']),
            'editFormUrl' => route('admin.api.form-manager', ['seo-edit']),
            'imagesUrl'   => route('resource.get', ['/']),
            'headers'     => $this->getAdminListHeader(),
        ];

        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_create') )
            $config['actions'][] = 'new';

        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_update') ) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }

        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_delete') )
            $config['actions'][] = 'delete';

        $config['actions'][] = 'search';
        $config['filters'] = $this->getFilters();

        return hcview('HCCoreUI::admin.content.list', ['config' => $config]);
    }

    /**
     * Creating Admin List Header based on Main Table
     *
     * @return array
     */
    public function getAdminListHeader()
    {
        return [
            'path'       => [
                "type"  => "text",
                "label" => trans('HCSeo::seo.path'),
            ],
//            'values_url' => [
//                "type"  => "external-button",
//                "label" => trans('HCSeo::seo.values_url'),
//            ],

        ];
    }

    /**
     * Create item
     *
     * @return mixed
     */
    protected function __apiStore()
    {
        $data = $this->getInputData();

        $record = HCSeo::create(array_get($data, 'record'));

        $record->values()->forceDelete();
        $record->values()->createMany(array_get($data, 'seo'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing item based on ID
     *
     * @param $id
     * @return mixed
     */
    protected function __apiUpdate(string $id)
    {
        $record = HCSeo::findOrFail($id);

        $data = $this->getInputData();

        $record->update(array_get($data, 'record', []));
        $record->values()->forceDelete();
        $record->values()->createMany(array_get($data, 'seo'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing specific items based on ID
     *
     * @param string $id
     * @return mixed
     */
    protected function __apiUpdateStrict(string $id)
    {
        HCSeo::where('id', $id)->update(request()->all());

        return $this->apiShow($id);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiDestroy(array $list)
    {
        HCSeo::destroy($list);

        return hcSuccess();
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiForceDelete(array $list)
    {
        HCSeo::onlyTrashed()->whereIn('id', $list)->forceDelete();

        return hcSuccess();
    }

    /**
     * Restore multiple records
     *
     * @param $list
     * @return mixed
     */
    protected function __apiRestore(array $list)
    {
        HCSeo::whereIn('id', $list)->restore();

        return hcSuccess();
    }

    /**
     * Creating data query
     *
     * @param array $select
     * @return mixed
     */
    protected function createQuery(array $select = null)
    {
        $with = [];

        HCSeo::$customAppends = ['values_url'];

        if( $select == null )
            $select = HCSeo::getFillableFields();

        $list = HCSeo::with($with)->select($select)
            // add filters
            ->where(function ($query) use ($select) {
                $query = $this->getRequestParameters($query, $select);
            });

        // enabling check for deleted
        $list = $this->checkForDeleted($list);

        // add search items
        $list = $this->search($list);

        // ordering data
        $list = $this->orderData($list, $select);

        return $list;
    }

    /**
     * List search elements
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     */
    protected function searchQuery(Builder $query, string $phrase)
    {
        return $query->where(function (Builder $query) use ($phrase) {
            $query->where('path', 'LIKE', '%' . $phrase . '%');
        });
    }

    /**
     * Getting user data on POST call
     *
     * @return mixed
     */
    protected function getInputData()
    {
        (new HCSeoValidator())->validateForm();

        $_data = request()->all();

        if( array_has($_data, 'id') )
            array_set($data, 'record.id', array_get($_data, 'id'));

        array_set($data, 'record.path', trim(array_get($_data, 'path'), '/'));


        $seoData = [];

        foreach ( request()->except('id', 'path') as $key => $content ) {

            if( starts_with($key, 'seo__') ) {
                $key = str_replace('seo__', '', $key);

                $value = ['content' => $content];

                if( $key == 'title' ) {
                    array_push($seoData, ['type' => 'title', 'name' => 'title'] + $value);
                    array_push($seoData, ['type' => 'name', 'name' => 'twitter:title'] + $value);
                    array_push($seoData, ['type' => 'property', 'name' => 'og:title'] + $value);
                    array_push($seoData, ['type' => 'itemprop', 'name' => 'name'] + $value);
                } else if( $key == 'description' ) {
                    array_push($seoData, ['type' => 'name', 'name' => 'description'] + $value);
                    array_push($seoData, ['type' => 'name', 'name' => 'twitter:description'] + $value);
                    array_push($seoData, ['type' => 'property', 'name' => 'og:description'] + $value);
                    array_push($seoData, ['type' => 'itemprop', 'name' => 'description'] + $value);
                } else if( $key == 'ogtype' ) {
                    array_push($seoData, ['type' => 'property', 'name' => 'og:type'] + $value);
                } else if( $key == 'ogurl' ) {
                    array_push($seoData, ['type' => 'property', 'name' => 'og:url'] + $value);
                } else if( $key == 'ogimage' ) {
                    array_push($seoData, ['type' => 'property', 'name' => 'og:image'] + $value);
                    array_push($seoData, ['type' => 'itemprop', 'name' => 'image'] + $value);
                } else if( $key == 'ogsite_name' ) {
                    array_push($seoData, ['type' => 'property', 'name' => 'og:site_name'] + $value);
                } else if( $key == 'twittercard' ) {
                    array_push($seoData, ['type' => 'name', 'name' => 'twitter:card'] + $value);
                } else if( $key == 'twittersite' ) {
                    array_push($seoData, ['type' => 'name', 'name' => 'twitter:site'] + $value);
                } else if( $key == 'twittercreator' ) {
                    array_push($seoData, ['type' => 'name', 'name' => 'twitter:creator'] + $value);
                }
            }
        }

        array_set($data, 'seo', $seoData);

        return makeEmptyNullable($data);
    }

    /**
     * Getting single record
     *
     * @param $id
     * @return mixed
     */
    public function apiShow(string $id)
    {
        $with = ['values'];

        $select = HCSeo::getFillableFields();

        $record = HCSeo::with($with)
            ->select($select)
            ->where('id', $id)
            ->firstOrFail();

        foreach ( $record->values->pluck('content', 'name') as $key => $content ) {
            $key = str_replace(':', '', $key);

            if( in_array($key, ['title', 'description', 'ogtype', 'ogurl', 'ogimage', 'ogsite_name', 'twittersite', 'twittercard', 'twittercreator']) ) {
                $record->{'seo__' . $key} = $content;
            }
        }

        return $record;
    }

    /**
     * Generating filters required for admin view
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = [];

        return $filters;
    }
}
