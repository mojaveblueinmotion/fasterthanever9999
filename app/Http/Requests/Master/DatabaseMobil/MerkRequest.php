<?php

namespace App\Http\Requests\Master\DatabaseMobil;

use Illuminate\Foundation\Http\FormRequest;

class MerkRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_merk_mobil,name,'.$id,
        ];

        return $rules;
    }
}
