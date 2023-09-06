<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
   
class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email:rfc,dns|required|unique:sys_users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tgl_lahir' => 'required',
            'roles'  => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $record = new User;
        try {
            $record->fill($request->only($record->fillable));
            if ($request->password) {
                $record->password = bcrypt($request->password);
            }
            $record->save();
            if ($record->id != 1) {
                $record->roles()->sync($request->roles ?? null);
            }
            $record->saveLogNotify();

            $success['token'] =  $record->createToken('MyAuthApp')->plainTextToken;
            $success['name'] =  $record->name;
    
            return $this->sendResponse($success, 'User created successfully.');
        } catch (\Exception $e) {
            return $record->rollbackSaved($e);
        }
        // $record->handleStoreOrUpdate($request);
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $user->roles()->sync(array_filter($request->roles ?? []));
        
    }
   
}