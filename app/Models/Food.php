<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Food extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = [
        'name', 'description',
        'ingredients', 'price', 'rate', 'types',
        'picturePath'
    ];

    protected $guarded = [
        'id'
    ];

     // epoch untuk FE
    public function getCreatedAtAttribute($value) {
        // membuat assesor untuk mengakses file yang sudah ada
        return Carbon::parse($value)->timestamp;
    }

    // epoch untuk FE
    public function getUpdatedAtAttribute($value) {
        // membuat assesor untuk mengakses file yang sudah ada
        return Carbon::parse($value)->timestamp;
    }

    // fungsi untuk merubah picture_path => picturePath
    public function toArray(){
        $toArray = parent::toArray();
        $toArray['picturePath'] = $this->picturePath;
        return $toArray;
    }

    // agar url nya lengkap
    public function getPicturePathAttribute(){
        return url('') . Storage::url($this->attributes['picturePath']) ;
    }

}
