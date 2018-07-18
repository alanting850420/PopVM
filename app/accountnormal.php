<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class accountnormal extends Model
{
    public $incrementing = false;
    protected $guarded=[];
    protected $table = 'account_normals';
}
