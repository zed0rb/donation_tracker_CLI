<?php
declare(strict_types=1);

namespace App\Model;

class Donation
{
    public function __construct(
        private readonly string $id,
        private string          $donorName,
        private float           $amount,
        private int             $charityId,
        private readonly string $dateTime
    )
    {
        $this->setDonorName($donorName);
        $this->setAmount($amount);
        $this->setCharityId($charityId);
    }

    public function setDonorName(string $donorName): void
    {
        if (empty($donorName)) {
            throw new \InvalidArgumentException("Donor name cannot be empty.");
        }
        $this->donorName = $donorName;
    }

    public function setAmount(float $amount): void
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Amount must be a positive number.");
        }
        $this->amount = $amount;
    }

    public function setCharityId(int $charityId): void
    {
        if ($charityId <= 0) {
            throw new \InvalidArgumentException("Charity ID must be a positive integer.");
        }
        $this->charityId = $charityId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDonorName(): string
    {
        return $this->donorName;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCharityId(): int
    {
        return $this->charityId;
    }

    public function getDateTime(): string
    {
        return $this->dateTime;
    }
}
