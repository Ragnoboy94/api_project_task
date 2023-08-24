<?php
// src/Form/ProductPurchaseType.php
namespace App\Form;

use App\Data\ProductPurchaseData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', ChoiceType::class, [
                'choices' => [
                    'Iphone' => '1',
                    'Наушники' => '2',
                    'Чехол' => '3',
                ],
            ])
            ->add('taxNumber', TextType::class)
            ->add('couponCode', TextType::class)
            ->add('paymentProcessor', ChoiceType::class, [
                'choices' => [
                    'PayPal' => 'paypal',
                    'Stripe' => 'stripe',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Укажите здесь класс, в котором будут храниться данные из формы
            'data_class' => ProductPurchaseData::class,
        ]);
    }
}