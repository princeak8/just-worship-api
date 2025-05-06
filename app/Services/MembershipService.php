<?php

namespace App\Services;

use App\Models\Membership;

class MembershipService
{
    public function save($data)
    {
        $membership = new Membership;

        $membership->firstname = $data['firstname'];
        $membership->surname = $data['surname'];
        $membership->email = $data['email'];
        $membership->country_id = $data['countryId'];
        $membership->save();

        return $membership;
    }

    public function members()
    {
        return Membership::orderBy("created_at", "DESC")->get();
    }

    public function getById($id)
    {
        return Membership::find($id);
    }

    public function getByEmail($email)
    {
        return Membership::where("email", $email)->first();
    }

    public function delete($member)
    {
        $member->delete();
    }
}