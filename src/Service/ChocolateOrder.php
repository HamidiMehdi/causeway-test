<?php

namespace App\Service;

use App\Entity\Order;
use App\Enum\DrinkEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\CoffeeMachine;

class ChocolateOrder implements DrinkOrderInterface
{

    const DRINK = 'Chocolate';
    const PRICE = 5;

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

        //on peut retourner une classe de type Chocolat mais elle ne me sert à rien
    }
}