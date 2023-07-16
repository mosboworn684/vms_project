<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models';
    protected $fillable = ['name', 'brand_id'];

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'model_id');
    }
}
