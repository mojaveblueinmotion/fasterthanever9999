<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class AssetRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'          => 'required|max:255|unique:ref_asset,name,'.$id,
            'asset_type_id' => 'required',
            'serial_number' => 'required|max:255',
            'merk'          => 'required|max:255',
            'regist_date'   => 'required|max:255',
        ];

        return $rules;
    }
}
