<?php

namespace App\Http\Requests\Master\Org;

use App\Http\Requests\FormRequest;

class RootRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'    => 'required|string|max:255|unique:sys_structs,name,'.$id.',id,level,root',
            'email'   => 'required|email',
            'website' => 'required|url',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:65500',
            'city_id' => 'required',
        ];

        return $rules;
    }
}
