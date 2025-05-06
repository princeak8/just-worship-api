<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveCenter;
use App\Http\Requests\UpdateCenter;

use App\Http\Resources\CenterResource;

use App\Services\CenterService;

use App\Utilities;

class CenterController extends Controller
{
    private $centerService;

    public function __construct()
    {
        $this->centerService = new CenterService;
    }

    public function save(SaveCenter $request)
    {
        $data = $request->validated();

        $center = $this->centerService->save($data);

        return Utilities::ok(new CenterResource($center));
    }

    public function update(UpdateCenter $request, $centerId)
    {
        $data = $request->validated();

        if (!is_numeric($centerId) || !ctype_digit($centerId)) return Utilities::error402("Invalid parameter centerId");

        $center = $this->centerService->getCenter($centerId);
        if(!$center) return Utilities::error402("center not Found");

        $center = $this->centerService->update($data, $center);

        return Utilities::ok(new CenterResource($center));
    }

    public function centers()
    {
        $centers = $this->centerService->getAllCenter();

        return Utilities::ok(CenterResource::collection($centers));
    }

    public function center($centerId)
    {
        if (!is_numeric($centerId) || !ctype_digit($centerId)) return Utilities::error402("Invalid parameter centerId");

        $center = $this->centerService->getCenter($centerId);
        if(!$center) return Utilities::error402("center not Found");

        return Utilities::ok(new CenterResource($center));
    }

    public function delete($centerId)
    {
        if (!is_numeric($centerId) || !ctype_digit($centerId)) return Utilities::error402("Invalid parameter centerId");

        $center = $this->centerService->getCenter($centerId);
        if(!$center) return Utilities::error402("center not Found");

        $this->centerService->delete($center);

        return Utilities::okay("Center Deleted");
    }
}
