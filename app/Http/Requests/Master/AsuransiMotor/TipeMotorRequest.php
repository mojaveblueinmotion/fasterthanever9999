<?php

namespace App\Http\Requests\Master\AsuransiMotor;

use Illuminate\Foundation\Http\FormRequest;

class TipeMotorRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255|unique:ref_tipe_motor,name,'.$id,
        ];

        return $rules;
    }
}
