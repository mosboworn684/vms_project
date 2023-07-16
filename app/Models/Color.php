<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $table = 'car_colors';
    protected $fillable = ['name'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'color_id');
    }
}
