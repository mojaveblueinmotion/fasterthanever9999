<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;


class UserRegisterController extends BaseController
{
    public function index()
    {
        $blogs = User::all();
        return $this->sendResponse(UserResource::collection($blogs), 'Data user berhasil diambil.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog = User::create($input);
        $blog->roles()->sync(array_filter($request->roles ?? []));
        return $this->sendResponse(new UserResource($blog), 'Post created.');
    }
   
    public function show($id)
    {
        $blog = User::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new UserResource($blog), 'Post fetched.');
    }
    
    public function update(Request $request, User $blog)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();
        
        return $this->sendResponse(new UserResource($blog), 'Post updated.');
    }
}
