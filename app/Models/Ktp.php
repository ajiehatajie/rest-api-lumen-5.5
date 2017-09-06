<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ktp extends Model 
{
    protected $fillable = [
        'nik','notes','kecamatan_id','user_id'
    ];
    
}