<?php

namespace App\Http\Requests\Setting\User;

use App\Http\Requests\FormRequest;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->record->id ?? 0;
        $rules = [
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|max:60|email|unique:sys_users,email,' . $id,
            // 'position_id' => 'required|exists:sys_positions,id',
            'status'      => 'required',
        ];
        if (!$id) {
            $rules += [
                'username'              => 'required|string|max:60|unique:sys_users,username,' . $id,
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
        }
        return $rules;
    }
}
