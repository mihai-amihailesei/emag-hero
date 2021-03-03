<?php


namespace Emag\Battle\Model;


class Turn
{
    protected int $turnNumber;
    protected Contestant $attacker;
    protected Contestant $defender;

    protected bool $hasDecidedVictor;

    protected TurnLogInterface $turnLog;

    public function __construct(int $turnNumber, Contestant $attacker, Contestant $defender, TurnLogInterface $turnLog)
    {
        $this->turnNumber = $turnNumber;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->turnLog = $turnLog;

        $this->hasDecidedVictor = false;
    }

    public function getTurnNumber(): int
    {
        return $this->turnNumber;
    }

    public function getAttacker(): Contestant
    {
        return $this->attacker;
    }

    public function getDefender(): Contestant
    {
        return $this->defender;
    }

    public function play(): void
    {
        $this->turnLog->addMessage("Turn $this->turnNumber: ");
        $defenderName = $this->defender->getName();

        $attackerHit = $this->attacker->attack($this->turnLog);
        $defenderDefense = $this->defender->defend($this->turnLog, $attackerHit);
        $defenderDamage = $attackerHit - $defenderDefense;
        $this->defender->takeDamage($defenderDamage);
        $this->turnLog->addMessage("The defender takes $defenderDamage damage! ");

        $defenderRemainingHealth = $this->defender->getCurrentHealth();
        if ($defenderRemainingHealth <= 0) {
            $this->hasDecidedVictor = true;
            $attackerName = $this->attacker->getName();
            $this->turnLog->addMessage("$attackerName has WON!!! $defenderName is now defeated! ");
            return;
        }
        $this->turnLog->addMessage("$defenderName has $defenderRemainingHealth health left");
    }

    public function getTurnLog(): TurnLogInterface
    {
        return $this->turnLog;
    }

    public function hasDecidedVictor(): bool
    {
        return $this->hasDecidedVictor;
    }
}
