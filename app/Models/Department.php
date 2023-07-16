<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $fillable = [
        'code',
        'name',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class, 'department_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function departments()
    {
        return $this->hasMany(RequestCar::class, 'department_car');
    }
}
