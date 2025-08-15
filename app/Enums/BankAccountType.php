<?php

namespace App\Enums;

enum BankAccountType: string
    {
        case LOCAL = 'local';
        case INTERNATIONAL = 'international';
    }