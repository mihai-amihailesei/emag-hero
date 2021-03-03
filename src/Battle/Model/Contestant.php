<?php


namespace Emag\Battle\Model;


interface Contestant
{
    public function attack(TurnLogInterface $turnLog): int;
    public function defend(TurnLogInterface $turnLog, int $hit): int;
    public function getName(): string;
    public function getSpeed(): int;
    public function isLucky(): bool;
    public function takeDamage(int $damage);
    public function getCurrentHealth();
}
