<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ads;

class AdsController extends Controller
{

    public function index()
    {
      $data = Ads::all();
       return $this->showResponse($data);
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


}
