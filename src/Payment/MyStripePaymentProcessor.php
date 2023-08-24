<?php
namespace App\Payment;

class MyStripePaymentProcessor implements PaymentProcessorInterface
{
    private $stripePaymentProcessor;

    public function __construct(StripePaymentProcessor $stripePaymentProcessor)
    {
        $this->stripePaymentProcessor = $stripePaymentProcessor;
    }

    public function processPayment(float $price): bool
    {
        return $this->stripePaymentProcessor->processPayment($price);
    }
}
