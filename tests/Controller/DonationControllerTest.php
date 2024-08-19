<?php

use App\Controller\DonationController;
use PHPUnit\Framework\TestCase;

class DonationControllerTest extends TestCase
{
    private string $tempFile;
    private DonationController $donationController;

    public function testAddDonation()
    {
        $this->donationController->addDonation(1, 'John Doe', 100.50);
        $donations = $this->donationController->loadDonationsByCharityId(1);

        $this->assertCount(1, $donations);
        $this->assertEquals('John Doe', $donations[0]->getDonorName());
        $this->assertEquals(100.50, $donations[0]->getAmount());
    }

    public function testLoadDonationsByCharityId()
    {
        $this->donationController->addDonation(1, 'John Doe', 100.50);
        $this->donationController->addDonation(2, 'Jane Doe', 150.75);

        $donations = $this->donationController->loadDonationsByCharityId(1);

        $this->assertCount(1, $donations);
        $this->assertEquals('John Doe', $donations[0]->getDonorName());
    }

    public function testLoadDonationsByEmptyInput()
    {
        $this->donationController->addDonation(1, 'John Doe', 100.50);
        $this->donationController->addDonation(2, 'Jane Doe', 150.75);

        $donations = $this->donationController->loadDonationsByCharityId(0);

        $this->assertCount(2, $donations);
        $this->assertEquals('John Doe', $donations[0]->getDonorName());
        $this->assertEquals('John Doe', $donations[0]->getDonorName());
    }

    public function testLoadDonationsForNonExistentCharity()
    {
        $donations = $this->donationController->loadDonationsByCharityId(999);

        $this->assertEmpty($donations);
    }

    protected function setUp(): void
    {
        $this->tempFile = tempnam(sys_get_temp_dir(), 'donations');
        $this->donationController = new DonationController($this->tempFile);
    }

    protected function tearDown(): void
    {
        // Remove test file after the test runs
        unlink($this->tempFile);

    }
}
