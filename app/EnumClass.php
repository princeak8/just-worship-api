<?php

namespace App;

use App\Enums\FileType;
use App\Enums\Role;

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

}