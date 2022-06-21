<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashsale extends Model
{
    use HasFactory;
    protected $table = 'flash_sale';
    public function allsale(){
        return $this->hasMany(Saleitem::class,'sale_id','id');
    }
}
