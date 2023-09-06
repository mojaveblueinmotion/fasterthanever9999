<?php

namespace App\Http\Requests\Master\DatabaseMobil;

use Illuminate\Foundation\Http\FormRequest;

class SeriRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'merk_id'     => 'required',
            'code'        => 'required|string|max:255|unique:ref_seri_mobil,code,'.$id,
            'model'       => 'required|string|max:255|unique:ref_seri_mobil,model,'.$id.',id,code,' . $this->code,
        ];

        return $rules;
    }
}
