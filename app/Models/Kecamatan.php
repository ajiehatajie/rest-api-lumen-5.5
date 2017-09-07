<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kecamatan extends Model 
{
    
    protected $fillable = [
        'name'
    ];


    public function ktp(){
        return $this->hasMany('App\Models\Ktp');        
    }
}