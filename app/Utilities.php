<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Services\AuthService;
use App\Models\HouseApprovalLog;
use App\Enums\HouseApprovalStatus;
use App\Enums\RealtorHouseRelationshipTypes;

use App\Models\RealtorHouse;

use App\Http\Resources\CircleResource;


class Utilities
{
    public $guard;
    public $reference;

    public function __construct($guard, $reference)
    {
        $this->guard = $guard;
        $this->reference = $reference;
    }

    public static function error($e, $message='')
    {
        Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
        return response()->json([
            'statusCode' => 500,
            'message' => ($message != '') ? $message : 'An error occured while trying to perform this operation, Please try again later or contact support',
            'error' => ($message != '') ? $message : 'An error occured while trying to perform this operation, Please try again later or contact support'
        ], 500);
    }

    public static function customError($message, $statusCode)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message
        ], $statusCode);
    }

    public static function logStuff($message)
    {
        Log::stack(['project'])->info($message);
    }

    public static function logValidation($message)
    {
        Log::stack(['validation'])->info($message);
    }

    public function refreshToken()
    {
        $authService = new AuthService($this->guard, $this->reference);
        return $authService->checkToRefreshToken();
    }

    public static function ok($data)
    {
        return response()->json([
            'statusCode' => 200,
            'data' => $data
        ], 200);
    }

    public static function okay($message='', $data=null, )
    {
        $responseData = ['statusCode' => 200];
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => 200,
            'data' => $data,
            'message' => $message
        ], 200);
    }

    public static function okay201($message='', $data=null, )
    {
        $responseData = ['statusCode' => 201];
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => 200,
            'data' => $data,
            'message' => $message
        ], 200);
    }

    public static function custom($statusCode, $res=[])
    {
        $responseData = ['statusCode' => $statusCode];
        $message = (isset($res['message'])) ? $res['message'] : '';
        $data = (isset($res['data'])) ? $res['data'] : '';
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function paginatedOk($data, $page, $perPage, $total)
    {
        $responseData = ['statusCode' => 200];
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => 200,
            'data' => $data,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            // 'token' => Utilities::refreshToken($this->guard)
        ], 200);
    }

    public static function paginatedOkay($data, $page, $perPage, $total)
    {
        $responseData = ['statusCode' => 200];
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => 200,
            'data' => $data,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            // 'token' => Utilities::refreshToken($this->guard)
        ], 200);
    }

    public static function ok2($data='')
    {
        $responseData = ['statusCode' => 200];
        if(!empty($data) || $data != '') $responseData['data'] = $data;
        return response()->json([
            'statusCode' => 200,
            'data' => $data,
            'token' => ''
        ], 200);
    }

    public static function logError($e)
    {
        Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine());
    }

    public static function error402($message)
    {
        return response()->json([
            'statusCode' => 402,
            'message' => $message,
            'error' => $message
        ], 402);
    }


    public static function retrievePhoneNumbersFromModels($phoneNumbers)
    {
        $phoneNumbersArray = [];
        if(count($phoneNumbers) > 0) {
            foreach($phoneNumbers as $phoneNumber) {
                $phoneNumbersArray[] = $phoneNumber->phone_number;
            }
        }
        return $phoneNumbersArray;
    }

}