<?php

use App\Utils\MoneyHandler;
use PHPUnit\Framework\TestCase;

class MoneyHandlerTest extends TestCase
{
    private MoneyHandler $moneyHandler;

    public function testHandleAmountWithValidInput()
    {
        $amount = $this->moneyHandler->handleAmountFormat("50.00");
        $this->assertEquals(50.00, $amount);
    }

    public function testHandleAmountWithCommaDecimal()
    {
        $amount = $this->moneyHandler->handleAmountFormat("50,00");
        $this->assertEquals(50.00, $amount);
    }

    public function testHandleAmountWithInvalidInput()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid amount: must be a numeric value.");

        $this->moneyHandler->handleAmountFormat("invalid");
    }

    public function testHandleAmountWithEmptyInput()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid amount: must be a numeric value.");

        $this->moneyHandler->handleAmountFormat("");
    }

    public function testHandleAmountWithNegativeValue()
    {
        $amount = $this->moneyHandler->handleAmount("-50.00");
        $this->assertEquals(-50.00, $amount);
    }

    protected function setUp(): void
    {
        $this->moneyHandler = new MoneyHandler();
    }
}
