<?php

namespace App\Enums;

enum Currency: string
    {
        case NAIRA = 'Naira';
        case DOLLAR = 'Dollars';
        case EURO = 'Euros';
        case POUNDS = 'Pounds';
    }