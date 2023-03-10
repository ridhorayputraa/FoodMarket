<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

         protected $fillable = [
            "food_id", "user_id", 'quantity', 'total', 'status',
            'payment_url'
        ];

    protected $guarded = [
        'id'
    ];


// Relation
public function food(){
    return $this->hasOne(Food::class, 'id', 'food_id');
}

public function user(){
    return $this->hasOne(User::class, 'id', 'user_id');
}

    // epoch untuk FE
    public function getCreatedAtAttribute($value) {
        // membuat assesor untuk mengakses file yang sudah ada
        return Carbon::parse($value)->timestamp;
    }

    // epoch untuk FE
    public function getUpdatedAtAttribute($value) {
        return Carbon::parse($value)->timestamp;
    }
}
