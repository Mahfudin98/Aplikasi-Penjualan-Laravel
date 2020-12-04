<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primarykey='id';

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
