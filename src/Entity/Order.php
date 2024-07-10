<?php

namespace App\Entity;

use App\Enum\DrinkEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;

#[Entity(repositoryClass: 'App\Repository\OrderRepository')]
#[Table(name: 'orders')]
class Order
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Column(type: Types::STRING)]
    private $drink;

    #[Column(type: Types::INTEGER)]
    private $sugar = 0;

    #[Column(type: Types::INTEGER)]
    private $milk = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDrink(): string
    {
        return $this->drink;
    }

    /**
     * @param mixed $drink
     */
    public function setDrink(string $drink): void
    {
        $this->drink = $drink;
    }

    public function getSugar(): int
    {
        return $this->sugar;
    }

    public function setSugar(int $sugar): void
    {
        $this->sugar = $sugar;
    }

    public function getMilk(): int
    {
        return $this->milk;
    }

    public function setMilk(int $milk): void
    {
        $this->milk = $milk;
    }
}