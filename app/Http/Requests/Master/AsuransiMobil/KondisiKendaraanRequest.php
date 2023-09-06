<?php

namespace App\Http\Requests\Master\AsuransiMobil;

use Illuminate\Foundation\Http\FormRequest;

class KondisiKendaraanRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_kondisi_kendaraan,name,'.$id,
        ];

        return $rules;
    }
}
