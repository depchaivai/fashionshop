<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product_interface';
    protected $primaryKey = 'id';
    public function thiscate(){
        return $this->hasOne(Cate::class,'id','cate');
    }
    public function thisth(){
        return $this->hasOne(Thuonghieu::class,'id','th');
    }
    public function allsalling(){
        return $this->hasMany(Saleproduct::class,'product_id','id');
    }
    public function firstview(){
        return $this->hasMany(Saleproduct::class,'product_id','id')->limit(1);
    }
    public function detailimg(){
        return $this->hasMany(DetailImg::class,'product_id','id');
    }
    public function flashsale(){
        return $this->hasOne(Saleitem::class,'product_id','id');
    }
    
}
