<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;

    protected $table = 'prefix';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'prefix_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'prefix_id');
    }
}
