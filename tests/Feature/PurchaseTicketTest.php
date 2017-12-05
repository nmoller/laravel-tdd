<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/12/17
 * Time: 2:09 PM
 */

namespace Tests\Feature;

use App\Billing\PaymentGateway;
use App\Concert;
use App\Billing\FakePaymentGateway;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PurchaseTicketTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    function customer_can_purchase_concert_tickets()
    {
        $paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $concert = factory(Concert::class)->create([
                'ticket_price' => 3250
        ]);


        $response = $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);

        $this->assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals(3, $order->tickets->count());
    }

    /**
     * @test
     */
    function email_is_required_to_purchase_tickets()
    {
        $this->withoutExceptionHandling();

        $paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $paymentGateway);
        $concert = factory(Concert::class)->create();

        $response = $this->json('POST', "/concerts/{$concert->id}/orders", [
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(422);
    }
}