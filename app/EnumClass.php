<?php

namespace App;

use App\Enums\FileType;

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

}