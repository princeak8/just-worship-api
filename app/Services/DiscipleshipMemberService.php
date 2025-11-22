<?php

namespace App\Services;

use App\Models\Discipleship;
use App\Models\DiscipleshipMember;

class DiscipleshipMemberService
{
    public function removeMember($member)
    {
        $member->delete();
    }

    public function getMember($discipleshipId, $email) {
        return DiscipleshipMember::where("discipleship_id", $discipleshipId)->where("email", $email)->first();
    }
}