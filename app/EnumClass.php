<?php

namespace App;

use App\Enums\FileType;
use App\Enums\Role;
use App\Enums\GivingRecurrentType;
use App\Enums\Currency;
use App\Enums\BankAccountType;

class EnumClass
{

    public static function fileTypes()
    {
        return [
            FileType::CSV->value,
            FileType::DOC->value,
            FileType::DOCX->value,
            FileType::IMAGE->value,
            FileType::PDF->value,
            FileType::VIDEO->value,
            FileType::XLS->value
        ];
    }

    public static function roles()
    {
        return [
            Role::ADMIN->value,
            Role::SUPER_ADMIN->value
        ];
    }

    public static function givingRecurrentTypes()
    {
        return [
            GivingRecurrentType::MONTHLY->value,
            GivingRecurrentType::YEARLY->value
        ];
    }

    public static function currencies()
    {
        return [
            Currency::DOLLAR->value,
            Currency::EURO->value,
            Currency::NAIRA->value,
            Currency::POUNDS->value
        ];
    }

    public static function bankAccountTypes()
    {
        return [
            BankAccountType::LOCAL->value,
            BankAccountType::INTERNATIONAL->value
        ];
    }

}