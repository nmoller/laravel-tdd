<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/12/17
 * Time: 3:53 PM
 */
namespace Tests\Unit\Billing;

use App\Billing\FakePaymentGateway;
use Tests\TestCase;

class FakePaymentGatewayTest extends TestCase
{
    /**
     * @test
     */
    function charges_with_a_valid_payment_token_are_succesful()
    {
        $paymentGateway = new FakePaymentGateway();

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());

        $this->assertEquals(2500, $paymentGateway->totalCharges());
    }
}