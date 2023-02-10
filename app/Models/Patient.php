<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_group',
        'chronic_diseases'
    ];

    protected $casts = [
        'blood_group' => \App\Enum\BloodGroup::class
    ];
}
