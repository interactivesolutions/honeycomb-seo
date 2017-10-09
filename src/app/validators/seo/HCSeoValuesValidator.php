<?php

namespace interactivesolutions\honeycombseo\app\validators\seo;

use interactivesolutions\honeycombcore\http\controllers\HCCoreFormValidator;

class HCSeoValuesValidator extends HCCoreFormValidator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}