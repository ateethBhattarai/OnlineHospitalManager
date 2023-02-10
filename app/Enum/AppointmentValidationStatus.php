<?php

namespace App\Enum;

enum AppointmentValidationStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Declined = 'declined';
    case CANCEL = 'cancel';
    case COMPLETED = 'completed';
}
