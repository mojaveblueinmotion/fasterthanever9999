<?php

namespace App\Http\Requests\Master\AsuransiMobil;

use Illuminate\Foundation\Http\FormRequest;

class LuasPertanggunganRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_luas_pertanggungan,name,'.$id,
        ];

        return $rules;
    }
}
