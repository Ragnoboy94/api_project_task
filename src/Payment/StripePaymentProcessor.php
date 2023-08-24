<?php
//src/Payment/StripePaymentProcessor.php
namespace App\Payment;//�� ���������� ������� ��� �������� ��������� � ������ ����.
class StripePaymentProcessor
{
    /**
     * @return bool true if payment was succeeded, false otherwise
     */
    public function processPayment(int $price): bool
    {
        if ($price < 10) {
            return false;
        }

        // process payment logic for Stripe
        return true;
    }
}