<?php

namespace App\Http\Requests\Master\DatabaseMobil;

use Illuminate\Foundation\Http\FormRequest;

class TipeRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'tahun_id'        => 'required',
            'name'        => 'required|string|max:255|unique:ref_tipe_mobil,name,'.$id.',id,tahun_id,' . $this->tahun_id,
        ];

        return $rules;
    }
}
