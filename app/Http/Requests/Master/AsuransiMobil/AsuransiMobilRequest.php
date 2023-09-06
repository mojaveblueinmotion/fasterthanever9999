<?php

namespace App\Http\Requests\Master\AsuransiMobil;

use Illuminate\Foundation\Http\FormRequest;

class AsuransiMobilRequest extends FormRequest
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
            'name'        => 'required|string|max:255|unique:ref_asuransi_mobil,name,'.$id,
            'perusahaan_asuransi_id' => 'required',
            'interval_pembayaran_id' => 'required',
            'pembayaran_persentasi' => 'required',
            'call_center' => 'required',
        ];

        return $rules;
    }
    
}
