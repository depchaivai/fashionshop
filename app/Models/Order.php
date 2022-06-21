<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = [
        'address_id',
        'user_id',
        'count',
        'discounts',
        'saleproduct_id'
    ];
    public function saleproduct(){
        return $this->hasOne(Saleproduct::class,'id','saleproduct_id');
    }
    public function address(){
        return $this->hasOne(Address::class,'id','address_id');
    }
    public static function boot()
    {
        parent::boot();

        self::creating(function($order){
            $salep = Saleproduct::find($order->saleproduct_id);
            if($salep->count < $order->count){
                return false;
            }
        });

        self::created(function($order){
            $salep = Saleproduct::find($order->saleproduct_id);
            $salep->count = $salep->count - $order->count;
            $salep->save();
        });

        
    }
}
