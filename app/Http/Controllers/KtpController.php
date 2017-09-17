<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KtpController extends Controller
{

    public function index()
    {
        $data = Ktp::paginate(20);

        return $this->listResponse($data);

    }

    public function KtpCreated(){
        $data   = Ktp::where('id',1)->with('Kecamatan')->get();

        return $this->listResponse($data);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'total' => 'required|numeric',
            'date_submission' => 'required',
            'notes_create'=>'required|min:5'
        ]);


        $createData = Ktp::create([
            'total'               => $request->input('total'),
            'kecamatan_id'        => \Auth::user()->kecamatan_id,
            'notes_create'        => $request->input('notes_create'),
            'date_submission'     => $request->input('date_submission'),
            'user_id'             => \Auth::user()->id,
        ]);

        if ($createData) {
           return $this->createdResponse($createData);
        }else{
            return $this->clientErrorResponse($createData);
        }


    }

    public function show($kecamatan,$date)
    {
            $id = kecamatan::where('name',urldecode($kecamatan))->first();
            //dd($id->id);

            //dd($id);
            //$kecamatan
            $data = Ktp::where('kecamatan_id',$id->id)
                    ->where('date_submission',$date)
                    ->with('user');

            if($data) {
               $result= $data->with('kecamatan')->get();
               $jumlah = count($result);

               if($jumlah > 0) {
                 return $this->showResponse($result);
               }
                 return $this->notFoundResponse();
            }

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
