<?php

namespace App\Http\Requests\Master\DatabaseMobil;

use Illuminate\Foundation\Http\FormRequest;

class TahunRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'merk_id'        => 'required',
            'seri_id'        => 'required',
            'harga'        => 'required',
            'tahun'        => 'required|string|max:255|unique:ref_tahun_mobil,tahun,'.$id.',id,seri_id,' . $this->seri_id,
        ];

        return $rules;
    }
}
