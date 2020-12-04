<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'customers';
    protected $fillable = ['email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function addCartCsid(){

        return Cart::create([
            'product_id' => $this->id,
        ]);
    }
}
