<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/12/17
 * Time: 3:53 PM
 */
namespace Tests\Unit\Billing;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentFailedException;
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

    /**
     * @test
     */
    function charges_with_an_invalid_payment_token_fails(){
        try{
            $paymentGateway = new FakePaymentGateway();

            $paymentGateway->charge(2500, 'invalid-payment-token');
        } catch (PaymentFailedException $e) {
            // to get over risky text message
            $this->assertNotNull($e);
            return;
        }

        $this->fail();

    }
}