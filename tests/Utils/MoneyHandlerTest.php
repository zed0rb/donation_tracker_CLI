<?php

use App\Utils\MoneyHandler;
use PHPUnit\Framework\TestCase;

class MoneyHandlerTest extends TestCase
{
    private MoneyHandler $moneyHandler;

    public function testHandleAmountWithValidInput()
    {
        $amount = $this->moneyHandler->handleAmount("50.00");
        $this->assertEquals(50.00, $amount);
    }

    public function testHandleAmountWithInvalidInput()
    {
        $amount = $this->moneyHandler->handleAmount("invalid");
        $this->assertNull($amount);
    }

    public function testHandleAmountWithMoreThanTwoDecimals()
    {
        $amount = $this->moneyHandler->handleAmount("50.555");
        $this->assertNull($amount);
    }

    public function testHandleAmountWithNegativeInput()
    {
        $amount = $this->moneyHandler->handleAmount("-10.00");
        $this->assertNull($amount);
    }

    public function testHandleAmountWithCommaDecimal()
    {
        $amount = $this->moneyHandler->handleAmount("50,00");
        $this->assertEquals(50.00, $amount);
    }

    protected function setUp(): void
    {
        $this->moneyHandler = new MoneyHandler();
    }
}
