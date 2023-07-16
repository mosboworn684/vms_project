<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statusdriver extends Model
{
    use HasFactory;
    protected $table = 'status_drivers';
    protected $fillable = ['name'];

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'status_id');
    }
}
