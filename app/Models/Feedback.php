<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table='feedback';
    public function thisp(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    public function thisuser(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
