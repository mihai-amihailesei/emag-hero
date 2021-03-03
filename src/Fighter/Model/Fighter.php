<?php


namespace Emag\Fighter\Model;


use Emag\Battle\Model\Contestant;

abstract class Fighter implements Contestant
{
    use  ChanceTrait;
    protected int $remainingHealth;

    public function __construct(
        protected string $name,
        protected int $health,
        protected int $strength,
        protected int $defense,
        protected int $speed,
        protected int $luck,
    ) {
        $this->remainingHealth = $this->health;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrentHealth(): int
    {
        return $this->remainingHealth;
    }

    public function takeDamage(int $damage)
    {
        $this->remainingHealth =  $this->remainingHealth - $damage;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function isLucky(): bool
    {
        return $this->determineLuck($this->luck);
    }
}
