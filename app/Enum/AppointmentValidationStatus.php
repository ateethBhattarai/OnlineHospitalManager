<?php

namespace App\Enum;

enum AppointmentValidationStatus: string
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case DECLINED = 'declined';
    case CANCEL = 'cancel';
    case COMPLETED = 'completed';
}
