<?php

use interactivesolutions\honeycombseo\app\models\HCSeo;

if( ! function_exists('formManagerSeoFields') ) {

    /**
     * Adding seo fields (title, description, keywords
     * used by Form-Managers
     *
     * @param array $list
     * @return mixed
     */
    function formManagerSeoFields(array &$list)
    {
        $list['structure'] = array_merge($list['structure'], [
            [
                "type"      => "singleLine",
                "fieldID"   => "seo__title",
                "label"     => trans("HCSeo::seo.seo_title"),
                "tabID"     => trans('HCTranslations::core.seo'),
                "maxLength" => 70,
            ],
            [
                "type"      => "textArea",
                "fieldID"   => "seo__description",
                "label"     => trans("HCSeo::seo.seo_description"),
                "tabID"     => trans('HCTranslations::core.seo'),
                "rows"      => 5,
                "maxLength" => 200,
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__ogtype",
                "label"    => trans("HCSeo::seo.seo_ogtype"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__ogurl",
                "label"    => trans("HCSeo::seo.seo_ogurl"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__ogimage",
                "label"    => trans("HCSeo::seo.seo_ogimage"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__ogsite_name",
                "label"    => trans("HCSeo::seo.seo_ogsitename"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],

            [
                "type"     => "singleLine",
                "fieldID"  => "seo__twittercard",
                "label"    => trans("HCSeo::seo.seo_tcard"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__twittersite",
                "label"    => trans("HCSeo::seo.seo_tsite"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
            [
                "type"     => "singleLine",
                "fieldID"  => "seo__twittercreator",
                "label"    => trans("HCSeo::seo.seo_tcreator"),
                "tabID"    => trans('HCTranslations::core.seo'),
            ],
        ]);
    }
}

if( ! function_exists('getSeoValuesByPath') ) {

    /**
     * Seo field content getting
     *
     * @param string|null $path
     * @return mixed
     */
    function getSeoValuesByPath(string $path = null)
    {
        if( is_null($path) ) {
            $path = request()->path();
        }

        $key = 'seo__' . $path;

        if( cache()->has($key) ) {
            return cache()->get($key);
        }

        $value = Cache::remember($key, 10, function () use ($path) {
            $seo = HCSeo::with(['values' => function ($query) {
                $query->orderBy('name', 'DESC');
            }])->where('path', $path)->first();

            if( $seo && $seo->values->isNotEmpty() ) {
                $metaTags = view('HCSeo::meta-tags', compact('seo'))->render();

                return $metaTags;
            }
        });

        return $value;
    }
}