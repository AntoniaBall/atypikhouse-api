<?php

namespace App\Services;

class PaymentService {

    public function createCharge($montant)
    {
        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        // \Stripe\Charge::create(array(
        //     "amount" => $data->getMontant() * 100,
        //     "currency" => "eur",
        //     "source" => "tok_visa",
        //     "description" => "First test charge!"
        // ));
    }
}