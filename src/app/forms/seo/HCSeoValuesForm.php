<?php

namespace interactivesolutions\honeycombseo\app\forms\seo;

class HCSeoValuesForm
{
    // name of the form
    protected $formID = 'seo-values';

    // is form multi language
    protected $multiLanguage = 0;

    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     */
    public function createForm(bool $edit = false)
    {
        $form = [
            'storageURL' => route('admin.api.routes.seo.{_id}.values', request('record_id')),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCTranslations::core.buttons.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
                    "type"            => "singleLine",
                    "fieldID"         => "name",
                    "label"           => trans("HCSeo::seo_values.name"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ], [
                    "type"            => "textArea",
                    "fieldID"         => "content",
                    "label"           => trans("HCSeo::seo_values.content"),
                    "required"        => 0,
                    "requiredVisible" => 0,
                ],
            ],
        ];

        if( $this->multiLanguage )
            $form['availableLanguages'] = getHCContentLanguages();

        if( ! $edit )
            return $form;

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }
}