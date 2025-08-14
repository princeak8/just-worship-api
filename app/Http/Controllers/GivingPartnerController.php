<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\SaveGivingPartner;
use App\Http\Requests\UpdateGivingPartner;

use App\Http\Resources\GivingPartnerResource;

use App\Services\GivingPartnerService;

use App\Models\GivingPartner;

use App\Utilities;

class GivingPartnerController extends Controller
{
    protected $partnerService;

    public function __construct()
    {
        $this->partnerService = new GivingPartnerService;
    }

    public function index(Request $request): JsonResponse
    {
        // Filter by recurrent status
        if ($request->has('recurrent')) $this->partnerService->recurrent = $request->boolean('recurrent');

        // Filter by giving option
        if ($request->has('giving_option_id')) $this->partnerService->givingOptionId = $request->givingOptionId;

        // Search by name or email
        if ($request->has('search')) $this->partnerService->searchText = $request->search;

        if ($request->has('perPage')) $this->partnerService->perPage = $request->get('perPage');
        
        $partners = $this->partnerService->partners();
    
        $res = ['data' => GivingPartnerResource::collection($partners)];
        if($request->has('perPage')) {
            $res['pagination'] = [
                'current_page' => $partners->currentPage(),
                'last_page' => $partners->lastPage(),
                'per_page' => $partners->perPage(),
                'total' => $partners->total(),
            ];
        }

        return Utilities::ok($res);
    }

    public function store(SaveGivingPartner $request): JsonResponse
    {
        try {
            $givingPartner = $this->partnerService->save($request->validated());

            return Utilities::okay('Thank you for partnering with us! Your information has been saved.', 
                                    new GivingPartnerResource($givingPartner));
        } catch (\Exception $e) {
            return Utilities::error($e, "An error occurred");
        }
    }

    public function show($partnerId): JsonResponse
    {
        if (!is_numeric($partnerId) || !ctype_digit($partnerId)) return Utilities::error402("Invalid parameter partnerId");

        $givingPartner = $this->partnerService->partner($partnerId);

        return Utilities::ok(new GivingPartnerResource($givingPartner));
    }

    public function update(UpdateGivingPartner $request, $partnerId): JsonResponse
    {
        try {
            $partner = $this->partnerService->partner($partnerId);

            if(!$partner) return Utilities::error402("Giving Partner not found");

            $partner = $this->partnerService->update($request->validated(), $partner);

            return Utilities::okay('Partner information updated successfully.', 
                                    new GivingPartnerResource($partner));
        } catch (\Exception $e) {
            return Utilities::error($e, "Something went wrong. Please try again.");
        }
    }

    public function destroy($partnerId): JsonResponse
    {
        try {
            $partner = $this->partnerService->partner($partnerId);

            if(!$partner) return Utilities::error402("Giving Partner not found");

            $this->partnerService->delete($partner);
            
            return Utilities::okay('Partner information deleted successfully.');
        } catch (\Exception $e) {
            return Utilities::error($e, 'Something went wrong. Please try again.');
        }
    }

    public function statistics(): JsonResponse
    {
        $stats = [
            'totalPartners' => GivingPartner::count(),
            'recurrentPartners' => GivingPartner::recurrent()->count(),
            'oneTimePartners' => GivingPartner::oneTime()->count(),
            'totalAmount' => GivingPartner::sum('amount'),
            'recurrentAmount' => GivingPartner::recurrent()->sum('amount'),
            'monthlyRecurrent' => GivingPartner::where('recurrent_type', 'Monthly')->count(),
            'yearlyRecurrent' => GivingPartner::where('recurrent_type', 'Yearly')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
