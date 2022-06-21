<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thuonghieu extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'thuonghieu';
    public function thiscate(){
        return $this->hasOne(Cate::class, 'id', 'cate');
    }
}
