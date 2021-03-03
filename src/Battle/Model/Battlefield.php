<?php


namespace Emag\Battle\Model;


class Battlefield
{
    /** @var \Emag\Battle\Model\Turn[] */
    protected array $turns;
    /** @var \Emag\Battle\Model\Contestant[] */
    protected array $participants;

    public function __construct(array $participants)
    {
        $this->participants = $participants;
    }

    public function presentParticipants()
    {
        $message = "The participants for the battle are: \n";
        foreach ($this->participants as $participant) {
            $message .= $participant->getName() . '! Health: ' . $participant->getCurrentHealth() . PHP_EOL;
        }

        return $message;
    }

    public function addTurn(Turn $turn): self
    {
        $this->turns[] = $turn;
        return $this;
    }
}
