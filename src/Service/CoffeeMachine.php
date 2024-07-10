<?php

namespace App\Service;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class CoffeeMachine
{

    private iterable $drinkHandlers;

    private EntityManagerInterface $manager;

    public function __construct(
        EntityManagerInterface $manager,
        #[TaggedIterator('app.drink.handler')] iterable $drinkHandlers
    )
    {
        $this->manager = $manager;
        $this->drinkHandlers = $drinkHandlers;
    }

    public function addWallet(int $solde)
    {
        $coffeeMachine = $this->getCoffeeMachine();
        $coffeeMachine->setWallet($coffeeMachine->getWallet() + $solde);
        $this->manager->flush();
    }

    public function resetWallet()
    {
        $coffeeMachine = $this->getCoffeeMachine();
        $coffeeMachine->setWallet(0);
        $this->manager->flush();
    }

    public function newOrder(Order $order)
    {
        foreach ($this->drinkHandlers as $drinkHandler) {
            if ($drinkHandler->support($order->getDrink())) {
                 $drinkHandler->execute($order, $this->getCoffeeMachine());
            }
        }
    }

    public function getCoffeeMachine()
    {
        return $this->manager->getRepository(\App\Entity\CoffeeMachine::class)->findOneBy([]);
    }

}