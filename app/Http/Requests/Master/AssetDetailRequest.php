<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class AssetDetailRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->id ?? 0;
        $asset_id = $this->asset_id ?? 0;
        // dd($id, $asset_id);
        $rules = [
            'asset_id'  => 'required',
            'name'  => [
                'required',
                'unique:ref_asset_detail,name,'.$id.',id,asset_id,'.$asset_id.''
            ],
            // 'name'      => Rule::unique('ref_asset_detail', 'name')
            //     ->ignore($id, 'id')
            //     ->ignore($asset_id, 'asset_id'),
        ];

        return $rules;
    }
}
