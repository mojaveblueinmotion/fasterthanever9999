<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class AssetTypeRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_asset_type,name,'.$id,
        ];

        return $rules;
    }
}
