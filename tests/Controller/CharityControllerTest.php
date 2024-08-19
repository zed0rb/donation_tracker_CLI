<?php

use App\Controller\CharityController;
use PHPUnit\Framework\TestCase;

class CharityControllerTest extends TestCase
{
    private string $tempFile;
    private CharityController $charityController;

    public function testAddCharity()
    {
        $this->charityController->addCharity("Test Charity", "test@example.com");
        $charities = $this->charityController->viewCharities();

        $this->assertCount(1, $charities);
        $this->assertEquals("Test Charity", $charities[1]->getName());
    }

    public function testDeleteCharity()
    {
        $this->charityController->addCharity("Test Charity", "test@example.com");
        $this->charityController->addCharity("Test1 Charity", "test1@example.com");

        $this->charityController->deleteCharity(1);
        $charities = $this->charityController->viewCharities();

        $this->assertCount(1, $charities);
    }

    protected function setUp(): void
    {
        // Create a temporary file for testing
        $this->tempFile = tempnam(sys_get_temp_dir(), 'charities');
        $this->charityController = new CharityController($this->tempFile);
    }

    protected function tearDown(): void
    {
        // Remove the temporary file
        unlink($this->tempFile);
    }
}
