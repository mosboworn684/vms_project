<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $fillable = ['prefix_id', 'firstname', 'lastname', 'tel', 'status_id'];

    public function prefix()
    {
        return $this->belongsTo(Prefix::class, 'prefix_id');
    }

    public function status()
    {
        return $this->belongsTo(Statusdriver::class, 'status_id');
    }

    public function drivers()
    {
        return $this->hasMany(RequestCar::class, 'driver_id');
    }

}
