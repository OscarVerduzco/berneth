<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TypUser extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = 'typUser';
}