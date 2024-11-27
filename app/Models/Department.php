<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['permissions_id', 'name'];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(user::class);
    }
}
