<?php

Route::group(['prefix' => config('hc.admin_url'), 'middleware' => ['web', 'auth']], function ()
{
    Route::get('seo', ['as' => 'admin.routes.seo.index', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@adminIndex']);

    Route::group(['prefix' => 'api/seo'], function ()
    {
        Route::get('/', ['as' => 'admin.api.routes.seo', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiIndexPaginate']);
        Route::post('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_create'], 'uses' => 'HCSeoController@apiStore']);
        Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiDestroy']);

        Route::get('list', ['as' => 'admin.api.routes.seo.list', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiIndex']);
        Route::post('restore', ['as' => 'admin.api.routes.seo.restore', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiRestore']);
        Route::post('merge', ['as' => 'api.v1.routes.seo.merge', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_create', 'acl:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiMerge']);
        Route::delete('force', ['as' => 'admin.api.routes.seo.force', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_force_delete'], 'uses' => 'HCSeoController@apiForceDelete']);

        Route::group(['prefix' => '{id}'], function ()
        {
            Route::get('/', ['as' => 'admin.api.routes.seo.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_list'], 'uses' => 'HCSeoController@apiShow']);
            Route::put('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiUpdate']);
            Route::delete('/', ['middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_delete'], 'uses' => 'HCSeoController@apiDestroy']);

            Route::put('strict', ['as' => 'admin.api.routes.seo.update.strict', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_update'], 'uses' => 'HCSeoController@apiUpdateStrict']);
            Route::post('duplicate', ['as' => 'admin.api.routes.seo.duplicate.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_list', 'acl:interactivesolutions_honeycomb_seo_routes_seo_create'], 'uses' => 'HCSeoController@apiDuplicate']);
            Route::delete('force', ['as' => 'admin.api.routes.seo.force.single', 'middleware' => ['acl:interactivesolutions_honeycomb_seo_routes_seo_force_delete'], 'uses' => 'HCSeoController@apiForceDelete']);
        });
    });
});
