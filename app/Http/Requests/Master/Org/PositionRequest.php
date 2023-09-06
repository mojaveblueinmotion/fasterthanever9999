<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class PositionRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'location_id' => 'required|exists:sys_structs,id',
            'name'        => 'required|string|max:255|unique:sys_positions,name,'.$id,
        ];

        return $rules;
    }
}
