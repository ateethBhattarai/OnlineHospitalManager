<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['visit_date_and_time', 'symptoms'];

    protected $casts = [
        'validation_status' => \App\Enum\AppointmentValidationStatus::class
    ];

    protected $primaryKey = "id";

    public function getPatientData()
    {
        return $this->hasOne(Appointment::class, 'patient_id');
    }

    public function getDoctorData()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}
