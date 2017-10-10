<?php

namespace interactivesolutions\honeycombseo\app\http\controllers\seo;

use Illuminate\Database\Eloquent\Builder;
use interactivesolutions\honeycombcore\http\controllers\HCBaseController;
use interactivesolutions\honeycombseo\app\models\HCSeo;
use interactivesolutions\honeycombseo\app\models\seo\HCSeoValues;
use interactivesolutions\honeycombseo\app\validators\seo\HCSeoValuesValidator;

class HCSeoValuesController extends HCBaseController
{

    //TODO recordsPerPage setting

    /**
     * Returning configured admin view
     *
     * @param $uuid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex($uuid = null)
    {
        $record = HCSeo::findOrFail($uuid);

        $config = [
            'title'       => trans('HCSeo::seo_values.page_title') . " '{$record->path}'",
            'listURL'     => route('admin.api.routes.seo.{_id}.values', $uuid),
            'newFormUrl'  => route('admin.api.form-manager', ['seo-values-new']) . '?record_id=' . $uuid,
            'editFormUrl' => route('admin.api.form-manager', ['seo-values-edit']) . '?record_id=' . $uuid,
            'imagesUrl'   => route('resource.get', ['/']),
            'headers'     => $this->getAdminListHeader(),
        ];

        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_values_create') )
            $config['actions'][] = 'new';

        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_values_update') ) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }
//
//        if( auth()->user()->can('interactivesolutions_honeycomb_seo_routes_seo_values_delete') )
//            $config['actions'][] = 'delete';

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
            'type'    => [
                "type"  => "text",
                "label" => trans('HCSeo::seo_values.type'),
            ],
            'name'    => [
                "type"  => "text",
                "label" => trans('HCSeo::seo_values.name'),
            ],
            'content' => [
                "type"  => "text",
                "label" => trans('HCSeo::seo_values.content'),
            ],

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

        $record = HCSeoValues::create(array_get($data, 'record'));

        return $this->apiShow($record->id);
    }

    /**
     * Updates existing item based on ID
     *
     * @param string $recordId
     * @param string $id
     * @return mixed
     */
    protected function __apiUpdate(string $recordId, string $id = null)
    {
        $record = HCSeoValues::findOrFail($id);

        $data = $this->getInputData();

        $record->update(array_get($data, 'record', []));

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
        HCSeoValues::where('id', $id)->update(request()->all());

        return $this->apiShow($id);
    }

    /**
     * Delete records table
     *
     * @param array $list
     * @return mixed
     */
    protected function __apiDestroy(array $list)
    {
        HCSeoValues::destroy($list);

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
        HCSeoValues::onlyTrashed()->whereIn('id', $list)->forceDelete();

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
        HCSeoValues::whereIn('id', $list)->restore();

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

        if( $select == null )
            $select = HCSeoValues::getFillableFields();

        $list = HCSeoValues::with($with)->select($select)
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
            $query->where('name', 'LIKE', '%' . $phrase . '%')
                ->orWhere('content', 'LIKE', '%' . $phrase . '%');
        });
    }

    /**
     * Getting user data on POST call
     *
     * @return mixed
     */
    protected function getInputData()
    {
        (new HCSeoValuesValidator())->validateForm();

        $_data = request()->all();

        if( array_has($_data, 'id') )
            array_set($data, 'record.id', array_get($_data, 'id'));

        array_set($data, 'record.record_id', request()->segment(4));
        array_set($data, 'record.type', array_get($_data, 'type'));
        array_set($data, 'record.name', array_get($_data, 'name'));
        array_set($data, 'record.content', array_get($_data, 'content'));

        return makeEmptyNullable($data);
    }

    /**
     * Getting single record
     *
     * @param string $recordId
     * @param string $id
     * @return mixed
     */
    public function apiShow(string $recordId, string $id = null)
    {
        $with = [];

        if( is_null($id) ) {
            $id = $recordId;
        }

        $select = HCSeoValues::getFillableFields();

        $record = HCSeoValues::with($with)
            ->select($select)
            ->where('id', $id)
            ->firstOrFail();

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
