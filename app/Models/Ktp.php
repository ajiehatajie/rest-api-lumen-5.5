<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ktp extends Model
{
    protected $fillable = [
        'notes_create','notes_update','kecamatan_id','user_id','date_submission','total'
    ];


    public function kecamatan(){
        return $this->belongsTo('App\Models\Kecamatan');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
