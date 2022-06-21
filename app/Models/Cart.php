<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public function thiscartproduct(){
        return $this->hasOne(Saleproduct::class,'id','product_sale');
    }
}
