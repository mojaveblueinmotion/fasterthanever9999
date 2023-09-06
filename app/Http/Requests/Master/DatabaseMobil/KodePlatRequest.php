<?php

namespace App\Http\Requests\Master\DatabaseMobil;

use Illuminate\Foundation\Http\FormRequest;

class KodePlatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'daerah'        => 'required',
            'name'        => 'required|string|max:255|unique:ref_kode_plat,name,'.$id.',id',
        ];

        return $rules;
    }
}
