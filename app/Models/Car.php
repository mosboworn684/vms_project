<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $fillable = ['regisNumber', 'type_id', 'brand_id', 'model_id', 'color_id', 'department_id', 'mileage', 'status_id', 'capacity'];

    public function types()
    {
        return $this->belongsTo(Typecar::class, 'type_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function models()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function provinces()
    {
        return $this->belongsTo(province::class, 'province_id');
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function status()
    {
        return $this->belongsTo(CarStatus::class, 'status_id');
    }

    public function cars()
    {
        return $this->hasMany(RequestCar::class, 'car_id');
    }
}
