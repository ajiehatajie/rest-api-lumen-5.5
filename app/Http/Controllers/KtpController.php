<?php 

namespace App\Http\Controllers;

use App\Models\Ktp;
use Illuminate\Http\Request;

class KtpController extends Controller
{

    public function index()
    {
        $data = Ktp::paginate(20);

        return $this->listResponse($data); 
        
    }

    public function create(Request $request)
    {   
        $this->validate($request, [
            'nik' => 'required|unique:ktps',
            'kecamatan_id' => 'required'
        ]);

        
        $createData = Ktp::create([
            'nik'           => $request->input('nik'),
            'kecamatan_id'  => $request->input('kecamatan'),
            'notes'         => $request->input('notes')
        ]);

        if ($createData) {
           return $this->createdResponse($createData);
        }else{
            return $this->clientErrorResponse($createData);
        }


    }

    public function show($id) 
    {
            $data = Ktp::find($id);

            if($data) {
                return $this->showResponse($data);
                
            }
            return $this->notFoundResponse();
    }   

    public function destroy($id) 
    {
            $data = Ktp::find($id);

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

