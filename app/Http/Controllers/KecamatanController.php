<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{

    public function index()
    {
        $data = Kecamatan::paginate(50);
        return $this->listResponse($data);
    }

    public function ktp($id)
    {
        $data = Kecamatan::where('id',$id)->with('ktp')->get();
        return $this->listResponse($data);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:kecamatans'

        ]);

        $createData = Kecamatan::create([
            'name'           => $request->input('name'),

        ]);

        if ($createData) {
             return $this->createdResponse($createData);
        }else{
            return $this->clientErrorResponse($createData);
        }


    }

    public function show($id)
    {       
            $kecamatan = urldecode($id);
            $data = Kecamatan::where('name',$kecamatan)->with('user')->get();

            //dd($data);
            
            if($data) {
                return $this->showResponse($data);

            }
            return $this->notFoundResponse();
    }

    public function destroy($id)
    {
            $data = Kecamatan::find($id);

            if($data) {
                $data->delete();
                return $this->deletedResponse();

            }
            return $this->notFoundResponse();
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
