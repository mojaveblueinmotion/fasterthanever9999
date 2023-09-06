<?php

namespace App\Http\Requests\Master\DataAsuransi;

use Illuminate\Foundation\Http\FormRequest;

class PerusahaanAsuransiRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_perusahaan_asuransi,name,'.$id,
        ];

        return $rules;
    }
}
