<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tgl_lahir' => $this->tgl_lahir->translatedFormat('d F Y'),
            // 'alamat' => $this->alamat,
            // 'username' => $this->username,
            // 'nik' => $this->nik,
            // 'image' => $this->image,
        ];
    }
}
