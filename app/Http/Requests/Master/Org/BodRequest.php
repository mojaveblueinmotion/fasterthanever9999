<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class BodRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'parent_id' => 'required|exists:sys_structs,id',
            'name'      => 'required|string|max:255|unique:sys_structs,name,'.$id.',id,level,bod',
        ];

        return $rules;
    }
}
