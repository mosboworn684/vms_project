<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSet extends Model
{
    use HasFactory;
    protected $table = 'status_set';
    protected $fillable = ['name'];

    public function requests()
    {
        return $this->hasMany(RequestCar::class, 'status_set_id');
    }
}
