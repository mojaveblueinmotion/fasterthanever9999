<?php

namespace App\Http\Requests\Asuransi;

use Illuminate\Foundation\Http\FormRequest;

class PolisMobilRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'no_asuransi' => 'required',
            'tanggal' => 'required',
            'agent_id' => 'required',
            'asuransi_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ];

        return $rules;
    }
}
