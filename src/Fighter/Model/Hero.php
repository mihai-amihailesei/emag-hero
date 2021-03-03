<?php


namespace Emag\Fighter\Model;


use Emag\Battle\Model\TurnLogInterface;

class Hero extends Fighter
{
    use ChanceTrait;

    public function __construct(
        $name,
        $health,
        $strength,
        $defense,
        $speed,
        $luck,
        protected Skill $attackSkill,
        protected Skill $defenseSkill,
    ) {
        parent::__construct($name, $health, $strength, $defense, $speed, $luck);
    }

    public function attack(TurnLogInterface $turnLog): int
    {
        if ($this->determineLuck($this->attackSkill->getActivationRate())) {
            $skillName = $this->attackSkill->getName();
            $damage = $this->attackSkill->actionModifier($this->strength);
            $turnLog->addMessage("{$this->name} attacks with $skillName! It deals $damage damage! ");
            return $damage;
        }

        $turnLog->addMessage("{$this->name} attacks for {$this->strength}! ");
        return $this->strength;
    }

    public function defend(TurnLogInterface $turnLog, int $hit): int
    {
        if ($this->determineLuck($this->defenseSkill->getActivationRate())) {
            $skillName = $this->defenseSkill->getName();
            $damage = $this->defenseSkill->actionModifier(null, $this->defense, $hit);
            $turnLog->addMessage("{$this->name} defends with $skillName! ");
            return $damage;
        }

        $turnLog->addMessage("{$this->name} defends! ");
        return $this->defense;
    }
}
