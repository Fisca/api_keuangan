<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\Storage;


class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'email' => ['required','email'],
            'password' => ['required', 'min:8'],
           
        ]);
        
        if($validator->fails()){
            return $this->responseError(['status'=>'false','LOGIN GAGAL', 422, $validator->errors()]);
        }

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
          
        ])){ 

        /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();
            $response = [
                'token' => $user->createToken('MyToken')->accessToken,
                'name' => $request->name,
            ];

            return $this->responseOk(['status'=>'true',$response]);
        }else{
            return $this->responseError('Pastikan memasukkan email dan password dengan benar', 401);
        }
       
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255'],
            'email' => 'required|email',
            'password' => ['required', 'min:8' ],
            'c_password' => ['required', 'same:password'],
        ]);

        if ($validator->fails()){
            return response()->json(['Registrasi Tidak Berhasil', 422, $validator->errors()]);
        }

        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'c_password' => $request->c_password,
        ];

       if($user= User::create($params)){
           $token = $user->createToken('MyToken')->accessToken;

           $response = [
               'token' => $token,
                'user' => $user,
           ];

           return response()->json([$response,'status'=>'true', 'message'=>'Registrasi Berhasil'], 400);

       }else{
            return response()->json(['Registrasi Tidak Berhasil', 422, $validator->errors()]);
       }

    }

    public function getProfile(Request $request){
        try {
            $user_id = $request->all();
            $data = User::find($user_id);

            return response()->json(['status'=>'true', 'message'=>'USER PROFILE', 'data'=> $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status'=>'false', 'message'=> $e->getMessage(), 'data'=> []], 500);
        }
    }

}