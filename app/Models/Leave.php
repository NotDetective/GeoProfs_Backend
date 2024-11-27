<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    //**
    // * changes the status from the english enum for the status to a dutch translation
    //  */
    public function getStatusAttribute($value)
    {
        return ['in behandeling', 'goedgekeurd', 'afgekeurd'][array_search($value, ['pending', 'approved', 'rejected'])];
    }
}
