<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;

    protected $table = 'status_requests';
    protected $fillable = ['name'];

    public function requests()
    {
        return $this->hasMany(RequestCar::class, 'status_id');
    }
}
