<?php

namespace App\Services;

use App\Models\GivingPartner;

class GivingPartnerService
{
    public $recurrent = null;
    public $givingOptionId = null;
    public $searchText = null;
    public $perPage = null;

    public function save($data)
    {
        $partner = new GivingPartner;
        $partner->firstname = $data['firstname'];
        $partner->surname = $data['surname'];
        $partner->email = $data['email'];
        $partner->phone = $data['phone'];
        $partner->country_id = $data['countryId'];
        $partner->amount = $data['amount'];
        $partner->currency = $data["currency"];
        $partner->recurrent = $data["recurrent"];
        $partner->recurrent_type = $data["recurrentType"];
        if(isset($data['prayerPoint'])) $partner->prayer_point = $data['prayerPoint'];
        if(isset($data['givingOptionId'])) $partner->giving_option_id = $data['givingOptionId'];
        $partner->save();

        return $partner;
    }

    public function update($data, $partner)
    {
        if(isset($data['firstname'])) $partner->firstname = $data['firstname'];
        if(isset($data['surname'])) $partner->surname = $data['surname'];
        if(isset($data['email'])) $partner->email = $data['email'];
        if(isset($data['phone'])) $partner->phone = $data['phone'];
        if(isset($data['countryId'])) $partner->country_id = $data['countryId'];
        if(isset($data['amount'])) $partner->amount = $data['amount'];
        if(isset($data['prayerPoint'])) $partner->prayer_point = $data['prayerPoint'];
        if(isset($data['givingOptionId'])) $partner->giving_option_id = $data['givingOptionId'];

        $partner->update();

        return $partner;
    }

    public function partners()
    {
        $query = GivingPartner::query();

        if($this->recurrent != null) $query->where("recurrent", $this->recurrent);

        if($this->givingOptionId) $query->where("giving_option_id", $this->givingOptionId);

        if($this->searchText) {
            $search = $this->searchText;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query = $query->orderBy("created_at", "DESC");

        if($this->perPage) return $query->paginate($this->perPage);

        return $query->get();
    }

    public function partner($id)
    {
        return GivingPartner::find($id);
    }

    public function delete($partner)
    {
        $partner->delete();
    }
}