<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'manager_id', 'leave_type_id', 'reason', 'status', 'date_leave', 'date_return'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->hasOne(LeaveType::class);
    }

    //**
    // * changes the status from the english enum for the status to a dutch translation
    //  */
    public function getStatusAttribute($value)
    {
        return ['in behandeling', 'goedgekeurd', 'afgekeurd'][array_search($value, ['pending', 'approved', 'rejected'])];
    }
}
