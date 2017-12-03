<?php
/**
 * Created by PhpStorm.
 * User: nmoller
 * Date: 03/12/17
 * Time: 4:21 PM
 */

namespace App\Billing;


interface PaymentGateway
{
    public function charge($amount, $token);
}