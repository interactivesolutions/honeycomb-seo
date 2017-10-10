<?php

namespace interactivesolutions\honeycombseo\app\forms;

class HCSeoForm
{
    // name of the form
    protected $formID = 'seo';

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
            'storageURL' => route('admin.api.routes.seo'),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCTranslations::core.buttons.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
                    "tabID"           => trans('HCTranslations::core.seo'),
                    "type"            => "singleLine",
                    "fieldID"         => "path",
                    "label"           => trans("HCSeo::seo.path"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
            ],
        ];

        formManagerSeoFields($form);

        if( $this->multiLanguage )
            $form['availableLanguages'] = getHCContentLanguages();

        if( ! $edit )
            return $form;

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }
}