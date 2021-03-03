<?php


namespace Emag\Battle\Model;


class TurnLog implements TurnLogInterface
{
    protected string $message = '';

    public function addMessage(string $message): void
    {
        $this->message .= $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
