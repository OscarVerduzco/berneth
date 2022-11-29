<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DetailPropertyType extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'detailPropertyType';
}