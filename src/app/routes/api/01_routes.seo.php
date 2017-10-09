<?php

Route::group(['prefix' => 'api', 'middleware' => ['auth-apps']], function ()
{
    Route::group(['prefix' => 'v1/seo'], function ()
    {
        Route::get('/', ['as' => 'api.v1.routes.seo', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_create'], 'uses' => 'HCSeoController@apiStore']);
        Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiDestroy']);

        Route::group(['prefix' => 'list'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.seo.list', 'middleware' => ['acl-apps:api_v1_interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiList']);
            Route::get('{timestamp}', ['as' => 'api.v1.routes.seo.list.update', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiIndexSync']);
        });

        Route::post('restore', ['as' => 'api.v1.routes.seo.restore', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.seo.merge', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_create', 'acl-apps:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiMerge']);
        Route::delete('force', ['as' => 'api.v1.routes.seo.force', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_force_delete'], 'uses' => 'HCSeoController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'api.v1.routes.seo.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiShow']);
            Route::put('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiDestroy']);

            Route::put('strict', ['as' => 'api.v1.routes.seo.update.strict', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'api.v1.routes.seo.duplicate.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_list', 'acl-apps:interactivesolutions_honeycomb_seo_routes_seo_create'], 'uses' => 'HCSeoController@apiDuplicate']);
            Route::delete('force', ['as' => 'api.v1.routes.seo.force.single', 'middleware' => ['acl-apps:interactivesolutions_honeycomb_seo_routes_seo_force_delete'], 'uses' => 'HCSeoController@apiForceDelete']);
        });
    });
});