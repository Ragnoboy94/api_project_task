<?php
// src/Payment/MyPaypalPaymentProcessor.php
namespace App\Payment;

class MyPaypalPaymentProcessor implements PaymentProcessorInterface
{
    private $paypalPaymentProcessor;

    public function __construct(PaypalPaymentProcessor $paypalPaymentProcessor)
    {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
    }

    public function processPayment(float $price): bool
    {
        $this->paypalPaymentProcessor->pay($price);
        return true;
    }
}