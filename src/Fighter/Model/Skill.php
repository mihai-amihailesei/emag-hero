<?php


namespace Emag\Fighter\Model;


class Skill
{
    public function __construct(
        protected string $action,
        protected string $name,
        protected string $description,
        protected int $activationRate,
    ) {
    }

    public function getActivationRate(): int
    {
        return $this->activationRate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function actionModifier(int $damage = null, int $defense = null, int $defenseHit = null) {
        return $this->{$this->action}($damage, $defense, $defenseHit);
    }

    public function rapid_strike(int $damage = null, int $defense = null, int $defenseHit = null)
    {
        return $damage * 2;
    }

    public function magic_shield(int $damage = null, int $defense = null, int $defenseHit = null)
    {
        return (int) $defense + (($defenseHit - $defense) / 2);
    }
}
