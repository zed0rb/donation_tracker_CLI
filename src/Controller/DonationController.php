<?php

namespace App\Controller;

use App\Model\Donation;
use App\Utils\CsvFileHandler;

readonly class DonationController
{
    private CsvFileHandler $csvHandler;

    public function __construct(
        private string $donationFilePath
    )
    {
        $this->csvHandler = new CsvFileHandler($this->donationFilePath);
    }

    public function addDonation(int $id, string $name, float $amount): void
    {
        $dateTime = date('Y-m-d H:i:s');

        $donation = new Donation(uniqid(), $name, $amount, $id, $dateTime);
        $this->saveDonation($donation);
    }

    private function saveDonation(Donation $donation): void
    {
        $data = $this->csvHandler->loadData();

        $data[] = [
            $donation->getId(),
            $donation->getDonorName(),
            $donation->getAmount(),
            $donation->getCharityId(),
            $donation->getDateTime()
        ];

        $header = ['ID', 'Donor Name', 'Amount', 'Charity ID', 'Date Time'];
        $this->csvHandler->saveData($data, $header);
    }

    public function loadDonationsByCharityId(int $charityId): array
    {
        $donations = [];
        $data = $this->csvHandler->loadData();

        foreach ($data as $row) {
            list($id, $donorName, $amount, $storedCharityId, $dateTime) = $row;

            // If charity ID is provided, filter by ID. Otherwise, include all donations.
            if ($charityId === 0 || (int)$storedCharityId === $charityId) {
                $donations[] = new Donation($id, $donorName, (float)$amount, (int)$storedCharityId, $dateTime);
            }
        }

        return $donations;
    }

}
