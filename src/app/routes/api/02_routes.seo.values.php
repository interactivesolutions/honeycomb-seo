<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/seo/{_id}/values'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.seo.{_id}.values', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_create'], 'uses' => 'seo\\HCSeoValuesController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.seo.{_id}.values.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.seo.{_id}.values.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.seo.{_id}.values.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.seo.{_id}.values.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_create', 'acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.seo.{_id}.values.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_force_delete'], 'uses' => 'seo\\HCSeoValuesController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.seo.{_id}.values.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_list'], 'uses' => 'seo\\HCSeoValuesController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_delete'], 'uses' => 'seo\\HCSeoValuesController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.seo.{_id}.values.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_update'], 'uses' => 'seo\\HCSeoValuesController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.seo.{_id}.values.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_list', 'acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_create'], 'uses' => 'seo\\HCSeoValuesController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.seo.{_id}.values.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_values_force_delete'], 'uses' => 'seo\\HCSeoValuesController@apiForceDelete']);
        });
    });
});