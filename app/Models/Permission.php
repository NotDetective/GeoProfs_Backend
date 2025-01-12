<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'system_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'permissions_id', 'id');
    }

}
