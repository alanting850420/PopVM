<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class account extends Model
{
    public $incrementing = false;
    protected $fillable = ['編號', 'id','password','name','level','黑武神','金遊',
                            '積巴', '巴爾','遊俠','魔光','黑騎','音速',
                        '富豪', '犽霸','更名卡','舒適','銀色','TOP100',
                        '車子數量', 'Koin','膠囊R','膠囊S','膠囊B','狀態'];
}
