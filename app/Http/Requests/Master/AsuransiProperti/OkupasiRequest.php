<?php

namespace App\Http\Requests\Master\AsuransiProperti;

use Illuminate\Foundation\Http\FormRequest;

class OkupasiRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'code'        => 'required|string|max:255|unique:ref_okupasi,code,'.$id,
            'name'        => 'required',
        ];

        return $rules;
    }
}
