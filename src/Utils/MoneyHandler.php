<?php
declare(strict_types=1);

namespace App\Utils;

class MoneyHandler
{
    public function handleAmountFormat(string $amountInput): ?float
    {
        // Replace comma with dot for decimal separation

        $normalizedAmount = str_replace(',', '.', $amountInput);

        // Check if the input is numeric (valid integer or float)
        if (!is_numeric($normalizedAmount)) {
            throw new \InvalidArgumentException("Invalid amount: must be a numeric value.");
        }

        return (float)$normalizedAmount;
    }
}
