<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case PHARMACIST = 'pharmacist';
}
