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
                "fieldID"   => "seo.seo_title",
                "label"     => trans("HCTranslations::core.seo_title"),
                "tabID"     => trans('HCTranslations::core.seo'),
                "maxLength" => 70,
            ],
            [
                "type"      => "textArea",
                "fieldID"   => "seo.seo_description",
                "label"     => trans("HCTranslations::core.seo_description"),
                "tabID"     => trans('HCTranslations::core.seo'),
                "rows"      => 5,
                "maxLength" => 155,
            ],
            [
                "type"    => "singleLine",
                "fieldID" => "seo.seo_keywords",
                "label"   => trans("HCTranslations::core.seo_keywords"),
                "tabID"   => trans('HCTranslations::core.seo'),
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
            $seo = HCSeo::with('values')->where('path', $path)->first();

            if( $seo && $seo->values->isNotEmpty() ) {
                $metaTags = view('HCSeo::meta-tags', compact('seo'))->render();

                return $metaTags;
            }
        });

        return $value;
    }
}