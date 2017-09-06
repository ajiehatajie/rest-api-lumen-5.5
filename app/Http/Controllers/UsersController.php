<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

   
    public function index()
    {
        $data = User::paginate(20);
        return $this->listResponse($data);
    }

    public function create(Request $request)
    {  
        $hasher = app()->make('hash');
        
        $this->validate($request, [
            'email'         => 'required|email|unique:users',
            'kecamatan_id'  => 'required',
            'password'      => 'required|min:3'
        ]);

        
        $createData = User::create([
            'email'           => $request->input('email'),
            'password'        => $hasher->make($request->input('password')),
            'kecamatan_id'    => $request->input('kecamatan_id'),
            'roles'           => 'admin'
        ]);

        if ($createData) {
           return $this->createdResponse($createData);
        }else{
            return $this->clientErrorResponse($createData);
        }


    }

    public function get_user(Request $request, $id)
    {
       

        $user = User::where('id', $id)->get();
        
        if ($user) {
              $res['success'] = true;
              $res['message'] = $user;
        
              return response($user);
        }else{
          $res['success'] = false;
          $res['message'] = 'Cannot find user!';
        
          return response($res);
        }
    }

    protected function showResponse($data)
    {
        $response = [
        'code' => 200,
        'status' => 'succcess',
        'data' => $data
        ];
        return response()->json($response, $response['code']);
    }

    protected function listResponse($data)
    {
        $response = [
        'code' => 200,
        'status' => 'succcess',
        'data' => $data
        ];
        return response()->json($response, $response['code']);
    }

    protected function notFoundResponse()
    {
        $response = [
        'code' => 404,
        'status' => 'error',
        'data' => 'Resource Not Found',
        'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    protected function createdResponse($data)
    {
        $response = [
        'code' => 201,
        'status' => 'succcess',
        'data' => $data
        ];
        return response()->json($response, $response['code']);
    }

    protected function clientErrorResponse($data)
    {
        $response = [
        'code' => 422,
        'status' => 'error',
        'data' => $data,
        'message' => 'Unprocessable entity'
        ];
        return response()->json($response, $response['code']);
    }

    protected function deletedResponse()
    {
        $response = [
        'code' => 204,
        'status' => 'success',
        'data' => [],
        'message' => 'Resource deleted'
        ];
        return response()->json($response, $response['code']);
    }

}