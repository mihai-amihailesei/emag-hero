<?php


namespace Emag\Battle\Model;


interface TurnLogInterface
{
    public function addMessage(string $message): void;
    public function getMessage(): string;
}
