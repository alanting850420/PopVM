<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ashe extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $fillable = ['更名卡', '黑武神','積巴','魔光','富豪','犽霸'];
    protected $dates = ['deleted_at'];
}
