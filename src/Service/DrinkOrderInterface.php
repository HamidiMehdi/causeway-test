<?php

namespace App\Service;

use App\Entity\Order;
use App\Enum\DrinkEnum;
use App\Entity\CoffeeMachine;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.drink.handler')]
interface DrinkOrderInterface
{
    public function support(string $drink);

    public function execute(Order $order, CoffeeMachine $coffeeMachine);
}
