<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
   public function register(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'email' =>  'required|email|unique:users,email',
            'password'  =>  'required'
        ]);

        $hasher = app()->make('hash');

        $username = $request['username'];
        $password = $hasher->make($request['password']);
        $email  =   $request['email'];

        $register = User::create([
            'username'  =>  $username,
            'email' =>  $email,
            'password'  =>  $password
        ]);

        if ($register) {
            $res['success'] = true;
            $res['message'] = 'Register Succes !';

            return response($res);
        }else {
            $res['success'] = false;
            $res['message'] = 'Register Failed !';

            return response($res);
        }
   }

   public function get_user(Request $request, $id) {
        $user = User::where('id', $id)->get();
        if ($user) {
            $res['success'] = true;
            $res['message'] = $user;

            return response($res);
        }else {
            $res['success'] =   false;
            $res['message'] = 'Cannot find user !';

            return response($res);
        }
   }
}
