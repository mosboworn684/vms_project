<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarStatus extends Model
{
    use HasFactory;

    protected $table = 'car_status';
    protected $fillable = ['name'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'status_id');
    }
}
