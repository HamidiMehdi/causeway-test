<?php

namespace App\DataTransferObject;

use function Symfony\Component\Translation\t;

class Wallet
{
    private int $wallet = 0;

    public function getWallet() : int
    {
        return $this->wallet;
    }

    public function setWallet(int $wallet): self
    {
        $this->wallet = $wallet;
        return $this;
    }
}