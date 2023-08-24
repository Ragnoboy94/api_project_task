<?php
// src/Service/PriceCalculatorService.php
namespace App\Service;

use App\Data\ProductPurchaseData;
use App\Payment\MyPaypalPaymentProcessor;
use App\Payment\MyStripePaymentProcessor;

class PriceCalculatorService
{
    private $paypalPaymentProcessor;
    private $stripePaymentProcessor;

    public function __construct(
        MyPaypalPaymentProcessor $paypalPaymentProcessor,
        MyStripePaymentProcessor $stripePaymentProcessor
    ) {
        $this->paypalPaymentProcessor = $paypalPaymentProcessor;
        $this->stripePaymentProcessor = $stripePaymentProcessor;
    }

    public function calculateTotalPrice(ProductPurchaseData $data): float
    {
        $productPrice = $this->getProductPrice($data->product);
        $taxRate = $this->getTaxRate($data->taxNumber);

        $totalPrice = $productPrice * (1 + $taxRate / 100);

        if ($data->couponCode) {
            $couponDiscount = $this->getCouponDiscount($data->couponCode, $totalPrice);
            $totalPrice -= $couponDiscount;
        }

        return $totalPrice;
    }

    private function getProductPrice(string $product): float
    {
        $productPrices = [
            '1' => 100,
            '2' => 20,
            '3' => 10,
        ];

        return $productPrices[$product] ?? 0;
    }

    private function getTaxRate(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);

        $taxRates = [
            'DE' => 19,
            'IT' => 22,
            'FR' => 20,
            'GR' => 24,
        ];

        return $taxRates[$countryCode] ?? 0;
    }

    private function getCouponDiscount(string $couponCode, float $totalPrice): float
    {
        $firstLetter = strtoupper(substr($couponCode, 0, 1));
        $couponValue = substr($couponCode, 1);

        if ($firstLetter === 'D') {
            $percentage = (float) $couponValue;
            if ($percentage > 0 && $percentage <= 100) {
                return $totalPrice * ($percentage / 100);
            }
        } elseif ($firstLetter === 'F') {
            $discountAmount = (float) $couponValue;
            if ($discountAmount > 0 && $discountAmount <= $totalPrice) {
                return $discountAmount;
            }
        }

        return 0;
    }

    public function processPurchase(string $paymentProcessor, float $totalPrice): bool
    {
        if ($paymentProcessor === 'paypal') {
            // Use MyPaypalPaymentProcessor
            $this->paypalPaymentProcessor->processPayment($totalPrice);
            return true;
        } elseif ($paymentProcessor === 'stripe') {
            // Use MyStripePaymentProcessor
            $this->stripePaymentProcessor->processPayment($totalPrice);
            return true;
        }

        return false; // Invalid payment processor
    }
}
