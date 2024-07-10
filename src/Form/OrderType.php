<?php

namespace App\Form;

use App\Entity\Order;
use App\Enum\DrinkEnum;
use App\Service\ChocolateOrder;
use App\Service\CoffeeOrder;
use App\Service\TeaOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('drink', ChoiceType::class, [
                'choices'  => [
                    'Café' => CoffeeOrder::DRINK,
                    'Thé' => TeaOrder::DRINK,
                    'Chocolat Chaud' => ChocolateOrder::DRINK,
                ]
            ])
            ->add('sugar', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 4
                ]
            ])
            ->add('milk', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 4
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
