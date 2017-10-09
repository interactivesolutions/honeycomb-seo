<?php namespace interactivesolutions\honeycombseo\app\validators;

use interactivesolutions\honeycombcore\http\controllers\HCCoreFormValidator;

class HCSeoValidator extends HCCoreFormValidator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'path' => 'required',

        ];
    }
}