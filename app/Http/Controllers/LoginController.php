<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */
     //9b8a1ec3ffc53633ac492ded030835db8760de36
    public function index(Request $request)
    {
        $hasher = app()->make('hash');

        $email = $request->input('email');
        $password = $request->input('password');

        $login = User::where('email', $email)->first();
        if (!$login) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';

            return response($res);
        }else{
            if ($hasher->check($password, $login->password)) {
                $api_token = sha1(time());
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $res['success'] = true;
                    $res['api_token'] = $api_token;
                    $res['message'] = $login;

                    return response($res);
                }
            }else{
                $res['success'] = true;
                $res['message'] = 'You email or password incorrect!';

                return response($res);
            }
        }
    }
}