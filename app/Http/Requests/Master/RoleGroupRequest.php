<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\FormRequest;

class RoleGroupRequest extends FormRequest
{
    public function rules()
    {
        $id = request()->id ?? 0;
        // dd(12, $id, request()->all());
        $rules = [
            'name'  => [
                'required',
                'unique:ref_role_groups,name,'.$id,
            ],
            'role_id'       => [
                'required',
            ],
            'asset_type_ids' => [
                'required',
            ],
        ];

        return $rules;
    }
}
