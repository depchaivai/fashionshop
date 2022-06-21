<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleproduct extends Model
{
    use HasFactory;
    protected $table="saleproduct";
    public function thisproduct(){
        return $this->hasOne(Product::class,'id','product_id');
    }
   
}
