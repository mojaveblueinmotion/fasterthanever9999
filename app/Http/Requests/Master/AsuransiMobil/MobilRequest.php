<?php

namespace App\Http\Requests\Master\AsuransiMobil;

use Illuminate\Foundation\Http\FormRequest;

class MobilRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'year'        => 'required',
            'merk'        => 'required',
            'type'        => 'required',
        ];

        return $rules;
    }
}
