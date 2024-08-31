<?php
declare(strict_types=1);

namespace App\Utils;

class MoneyHandler
{
    public function handleAmount(string $amountInput): ?float
    {
        // Replace comma with dot for decimal separation
        $normalizedAmount = str_replace(',', '.', $amountInput);

        if (!is_numeric($normalizedAmount)) {
            return null;
        }

        $amount = (float)$normalizedAmount;

        if ($amount <= 0) {
            return null;
        }

        // Check if the amount is an integer or a float with no more than two decimal places
        if (ctype_digit($normalizedAmount) || preg_match('/^\d+(\.\d{1,2})?$/', $normalizedAmount)) {
            return $amount;
        }
        return null;
    }
}
