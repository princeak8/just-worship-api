<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveBankAccount;
use App\Http\Requests\UpdateBankAccount;

use App\Http\Resources\BankAccountResource;

use App\Services\BankAccountService;

use App\Utilities;

class BankAccountController extends Controller
{
    private $bankAccountService;

    public function __construct()
    {
        $this->bankAccountService = new BankAccountService;
    }

    public function save(SaveBankAccount $request)
    {
        $data = $request->validated();

        $bankAccount = $this->bankAccountService->save($data);

        return Utilities::ok(new BankAccountResource($bankAccount));
    }

    public function update($bankAccountId, UpdateBankAccount $request)
    {
        if (!is_numeric($bankAccountId) || !ctype_digit($bankAccountId)) return Utilities::error402("Invalid parameter bankAccountId");

        $bankAccount = $this->bankAccountService->account($bankAccountId);
        if(!$bankAccount) return Utilities::error402("bank Account not found");

        $data = $request->validated();

        $bankAccount = $this->bankAccountService->update($data, $bankAccount);

        return Utilities::ok(new BankAccountResource($bankAccount));
    }

    public function delete($bankAccountId)
    {
        if (!is_numeric($bankAccountId) || !ctype_digit($bankAccountId)) return Utilities::error402("Invalid parameter bankAccountId");

        $bankAccount = $this->bankAccountService->account($bankAccountId);
        if(!$bankAccount) return Utilities::error402("bank Account not found");

        $this->bankAccountService->delete($bankAccount);

        return Utilities::okay("Bank Account deleted Successfully");
    }

    public function account($bankAccountId)
    {
        if (!is_numeric($bankAccountId) || !ctype_digit($bankAccountId)) return Utilities::error402("Invalid parameter bankAccountId");

        $bankAccount = $this->bankAccountService->account($bankAccountId);
        if(!$bankAccount) return Utilities::error402("bank Account not found");

        return Utilities::ok(new BankAccountResource($bankAccount));
    }

    public function accounts()
    {
        $bankAccounts = $this->bankAccountService->accounts();

        return Utilities::ok(BankAccountResource::collection($bankAccounts));
    }
}
