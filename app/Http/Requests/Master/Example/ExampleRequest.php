<?php

namespace App\Http\Requests\Master\Example;

use App\Http\Requests\FormRequest;

class ExampleRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_examples,name,'.$id,
        ];

        return $rules;
    }
}
