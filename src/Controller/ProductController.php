<?php
// src/Controller/ProductController.php
namespace App\Controller;

use App\Form\ProductPurchaseType;
use App\Service\PriceCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request                $request,
        PriceCalculatorService $priceCalculatorService
    ): JsonResponse
    {
        $form = $this->createForm(ProductPurchaseType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isValid()) {
            $errors = $form->getErrors(true, true);
            return new JsonResponse(['errors' => $errors], 400);
        }

        $data = $form->getData();
        $totalPrice = $priceCalculatorService->calculateTotalPrice($data);

        return new JsonResponse(['total_price' => $totalPrice], 200);
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchaseProduct(
        Request                $request,
        PriceCalculatorService $priceCalculatorService
    ): JsonResponse
    {
        $form = $this->createForm(ProductPurchaseType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isValid()) {
            $errors = $form->getErrors(true, true);
            return new JsonResponse(['errors' => $errors], 400);
        }

        $data = $form->getData();

        // Process the purchase using the specified payment processor
        $paymentProcessor = $data->paymentProcessor;
        $totalPrice = $priceCalculatorService->calculateTotalPrice($data);
        $success = $priceCalculatorService->processPurchase($paymentProcessor,$totalPrice);

        if (!$success) {
            return new JsonResponse(['error' => 'Payment processing failed'], 400);
        }

        return new JsonResponse(['message' => 'Purchase successful'], 200);
    }
}