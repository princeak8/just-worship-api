<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class UniqueRecurrent implements ValidationRule
{
    private $table;
    private $column;
    private $additionalWhere;
    private $customMessage;

    public function __construct($table, $column, $additionalWhere = [], $message = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->additionalWhere = $additionalWhere;
        $this->customMessage = $message;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!request()->boolean('recurrent')) {
            return; // If not recurrent, don't apply unique constraint
        }

        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->where('recurrent', true);

        // Apply additional where conditions
        foreach ($this->additionalWhere as $column => $val) {
            $query->where($column, $val);
        }

        if ($query->count() > 0) {
            $message = $this->customMessage ?: "This {$attribute} is already used for a recurring donation.";
            $fail($message);
        }
    }
}
