<?php


namespace Emag\Fighter\Model;


use Emag\Battle\Model\TurnLogInterface;

class Beast extends Fighter
{

    public function attack(TurnLogInterface $turnLog): int
    {
        $turnLog->addMessage("{$this->name} attacks for {$this->strength}! ");
        return $this->strength;
    }

    public function defend(TurnLogInterface $turnLog, int $hit): int
    {
        $turnLog->addMessage("{$this->name} defends! ");
        return $this->defense;
    }
}
