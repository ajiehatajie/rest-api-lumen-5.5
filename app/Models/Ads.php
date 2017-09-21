<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ads extends Model
{

    protected $table = 'ads';
    
    protected $fillable = [
        'adsid','type','desc'
    ];



}
