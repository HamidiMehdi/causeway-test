<?php

namespace App\Service;

use App\Entity\Order;
use App\Enum\DrinkEnum;
use App\Entity\CoffeeMachine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CoffeeOrder implements DrinkOrderInterface
{

    const DRINK = 'Coffee';
    const PRICE = 2;

    private EntityManagerInterface $manager;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $manager) {
        $this->requestStack = $requestStack;
        $this->manager = $manager;
    }

    public function support(string $drink)
    {
        return $drink === self::DRINK;
    }

    public function execute(Order $order, CoffeeMachine $coffeeMachine)
    {
        if ($coffeeMachine->getWallet() < self::PRICE) {
            $this->requestStack->getSession()->getFlashBag()->add('danger', 'Vous n\'avez pas assez de solde');
            return;
        }

        $coffeeMachine->setWallet($coffeeMachine->getWallet() - self::PRICE);
        $this->manager->persist($order);
        $this->manager->flush();

        $this->requestStack->getSession()->getFlashBag()->add('success', 'Votre boisson est prête');

        //on peut retourner une classe de type Coffee mais elle ne me sert à rien
    }
}