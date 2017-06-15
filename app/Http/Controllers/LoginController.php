<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
class LoginController extends Controller
{
   public function index(Request $request) {
        $this->validate($request, [
            'email' =>  'required',
            'password'  =>  'required'
        ]);
        $hasher = app()->make('hash');
        $email = $request['email'];
        $password = $hasher->make($request['password']);

        $login = User::where('email', $email)->first();
        // echo "<pre>";
        // echo $login;
        // echo "</pre>";
        // die();
        if (!$login) {
            // dd('masuk');
            $res['success'] = false;
            $res['message'] = 'Email atau Password Salah';

            return response($res);
        }else {
                // dd($hasher->check($password, 12345));
            if ($password = $login->password) {
                $api_token = sha1(time());
                // dd($api_token);
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);

                if ($create_token) {
                    $res['success'] = true;
                    $res['api_token']   =   $api_token;
                    $res['message'] = $login;

                    return response($res);
                }else {
                    $res['success'] = false;
                    $res['message'] = 'Email atau Password Salah';

                    return response($res);
                }
            }
        }
   }
}
