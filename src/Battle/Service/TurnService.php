<?php


namespace Emag\Battle\Service;


use Emag\Battle\Model\Contestant;
use Emag\Battle\Model\Turn;
use Emag\Battle\Model\TurnLog;

class TurnService
{
    public function createTurn(Contestant $attacker, Contestant $defender): Turn
    {
        return new Turn(1, $attacker, $defender, new TurnLog());
    }

    public function nextTurn(Turn $turn): ?Turn
    {
        if ($turn->hasDecidedVictor()) {
            return null;
        }
        return new Turn($turn->getTurnNumber() + 1, $turn->getDefender(), $turn->getAttacker(), new TurnLog());
    }

    public function determineFirstTurnOrder(Contestant $contestant1, Contestant $contestant2): array
    {
        if ($contestant1->getSpeed() > $contestant2->getSpeed()) {
            return ['attacker' => $contestant1, 'defender' => $contestant2];
        } else {
            return ['attacker' => $contestant2, 'defender' => $contestant1];
        }
    }
}
