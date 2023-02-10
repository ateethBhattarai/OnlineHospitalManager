<?php

namespace App\Enum;

enum BloodGroup: string
{
    case O_positive =  'O +';
    case O_negative = 'O -';
    case A_positive = 'A +';
    case A_negative = 'A -';
    case B_positive = 'B +';
    case B_negative = 'B -';
    case AB_positive = 'AB +';
    case AB_negative = 'AB -';
}
