<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DetailUserType extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'detailUserType';
}