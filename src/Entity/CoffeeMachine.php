<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;

#[Entity(repositoryClass: 'App\Repository\CoffeeMachineRepository')]
#[Table(name: 'coffee_machine')]
class CoffeeMachine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Column(type: Types::INTEGER)]
    private $wallet = 0;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getWallet(): int
    {
        return $this->wallet;
    }

    public function setWallet(int $wallet): void
    {
        $this->wallet = $wallet;
    }
}
