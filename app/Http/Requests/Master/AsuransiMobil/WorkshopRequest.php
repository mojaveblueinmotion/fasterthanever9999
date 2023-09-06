<?php

namespace App\Http\Requests\Master\AsuransiMobil;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_workshop,name,'.$id,
            'province_id' => 'required',
            'city_id' => 'required',
            'link_maps' => 'required',
            'alamat' => 'required',
        ];

        return $rules;
    }
}
