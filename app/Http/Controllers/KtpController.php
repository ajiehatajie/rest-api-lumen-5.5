<?php

namespace App\Http\Controllers;
use Log;
use App\Models\Ktp;
use App\Models\Log as Visitor;
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
            'notes'=>'required|min:15'
        ]);

        $id_user         = \Auth::user()->id;
        $kecamatan_id    = \Auth::user()->kecamatan_id;

        $data = Ktp::where('kecamatan_id',$kecamatan_id)
                ->where('date_submission',$request->input('date_submission'))->get();

        if(count($data) == 0 ) {
            #data belum ada baru input
            $createData = Ktp::create([
                'total'               => $request->input('total'),
                'kecamatan_id'        => \Auth::user()->kecamatan_id,
                'notes_create'        => $request->input('notes'),
                'date_submission'     => $request->input('date_submission'),
                'user_id'             => \Auth::user()->id,
            ]);

            if ($createData) {
               return $this->createdResponse($createData);
            }else{
                return $this->clientErrorResponse($createData);
            }
        } else {

            $data = ['message'=> 'data has been duplicate',] ;
            return $this->clientErrorResponse($data);
        }



    }

    public function update(Request $request,$date_submission)
    {
        //dd($date_submission);
        $this->validate($request, [
            'notes'=>'required|min:10|max:200',
            'total'=>'required|numeric'
        ]);

        $id_user         = \Auth::user()->id;
        $kecamatan_id    = \Auth::user()->kecamatan_id;

        $data = Ktp::where('kecamatan_id',$kecamatan_id)
                 ->where('date_submission',$date_submission)->first();

        #dd(count($data));

        if(count($data) > 0) {

            $data->status=1;
            $data->notes_update = $request->input('notes');
            $data->update_by    = $id_user;
            $data->total_update = $request->input('total');
            $data->save();

            return $this->createdResponse($data);

        } else {
            #input data baru
            $createData = Ktp::create([
                'total'               => $request->input('total'),
                'total_update'        => $request->input('total'),
                'kecamatan_id'        => $kecamatan_id,
                'notes_create'        => $request->input('notes'),
                'notes_update'        => $request->input('notes'),
                'date_submission'     => $date_submission,
                'user_id'             => $id_user,
                'update_by'           => $id_user,
                'status'              => 1 //status ektp sudah jadi
            ]);

            if ($createData) {
               return $this->createdResponse($createData);
            }else{
                return $this->clientErrorResponse($createData);
            }
        }


    }

    public function show($kecamatan,$date)
    {
            $req = $request->all();
            $log = array('manufacturer' => $req['manufacturer'],
            'devicename'        => $req['devicename'],
            'brand'             => $req['brand'],
            'deviceid'          => $req['deviceid'],
            'os'                => $req['os']
            );

            #$this->LogSave($log);

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

    protected function LogSave($data) {

        $record = app()->geoip->getLocation();
        Log::info('succes log: '.$data['brand']);
        $logsave = new Visitor();
        $logsave->ip = $record['ip'];
        $logsave->iso= $record['isoCode'];
        $logsave->country = $record['country'];
        $logsave->manufacturer=$data['manufacturer'];
        $logsave->devicename = $data['devicename'];
        $logsave->brand      = $data['brand'];
        $logsave->deviceid  = $data['deviceid'];
        $logsave->os =$data['os'];
        $logsave->save();




    }



}
