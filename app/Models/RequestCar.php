<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCar extends Model
{
    use HasFactory;

    protected $table = 'requests_cars';
    protected $fillable = ['requestNo', 'user_id', 'startTime', 'endTime', 'location', 'passenger', 'type_id'
        , 'detail', 'status_id', 'car_id', 'driver_id', 'returnTime', 'status_return'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function types()
    {
        return $this->belongsTo(Typecar::class, 'type_id');
    }

    public function status()
    {
        return $this->belongsTo(RequestStatus::class, 'status_id');
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_car');
    }

    public function statussets()
    {
        return $this->belongsTo(StatusSet::class, 'status_set_id');
    }

    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

}
