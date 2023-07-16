<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $fillable = ['name'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'province_id');
    }
}
