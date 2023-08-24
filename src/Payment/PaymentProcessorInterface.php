<?php
// src/Payment/PaymentProcessorInterface.php
namespace App\Payment;

interface PaymentProcessorInterface
{
    public function processPayment(float $price): bool;
}