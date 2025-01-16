<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['permissions_id', 'name'];

    public function permissions()
    {
        return $this->belongsTo(Permission::class, 'permissions_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(user::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
