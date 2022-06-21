<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleitem extends Model
{
    use HasFactory;
    protected $table = 'item_sale';
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
