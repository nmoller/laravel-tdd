<?php

namespace App\Http\Controllers;

use App\Concert;
use Illuminate\Http\Request;
use App\Billing\PaymentGateway;

class ConcertOrdersController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId)
    {
        $this->validate(request(), [
           'email' => 'required',
        ]);
        // Charging the customer
        $concert = Concert::find($concertId);
        $ticketQuantity = request('ticket_quantity');
        $amount = $ticketQuantity * $concert->ticket_price;
        $this->paymentGateway->charge($amount, request('payment_token'));

        // Creating the order
        $order = $concert->orderTickets(request('email'), $ticketQuantity);

        return response()->json([], 201);
    }
}
