<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typecar extends Model
{
    use HasFactory;
    protected $table = 'car_types';
    protected $fillable = [
        'name',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class, 'type_id');
    }

    public function requests()
    {
        return $this->hasMany(RequestCar::class, 'type_id');
    }
}
