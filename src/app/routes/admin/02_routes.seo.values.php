<?php

Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('seo/{_id}/values', ['as' => 'admin.routes.seo.{_id}.values.index', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@adminIndex']);

    Route::group(['prefix' => 'api/seo/{_id}/values'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.seo.{_id}.values', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_create'], 'uses' => 'seo\\HCSeoValuesController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.seo.{_id}.values.list', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.seo.{_id}.values.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.seo.{_id}.values.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_create', 'acl:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.seo.{_id}.values.force', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_force_delete'], 'uses' => 'seo\\HCSeoValuesController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.seo.{_id}.values.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.seo.{_id}.values.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.seo.{_id}.values.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_list', 'acl:interactivesolutions_honeycomb_seo_routes_seo_values_create'], 'uses' => 'seo\\HCSeoValuesController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.seo.{_id}.values.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_values_force_delete'], 'uses' => 'seo\\HCSeoValuesController@apiForceDelete']);
        });
    });
});
