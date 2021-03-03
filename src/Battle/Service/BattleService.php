<?php


namespace Emag\Battle\Service;


use Emag\Battle\Model\Battlefield;

class BattleService
{
    protected TurnService $turnService;
    protected ContestantFactory $contestantFactory;

    public function __construct(TurnService $turnService, ContestantFactory $contestantFactory)
    {
        $this->turnService = $turnService;
        $this->contestantFactory = $contestantFactory;
    }

    public function fight(string $contestant1, string $contestant2): iterable|Battlefield
    {
        $contestant1 = $this->contestantFactory->buildContestant($contestant1);
        $contestant2 = $this->contestantFactory->buildContestant($contestant2);

        $battlefield = new Battlefield([$contestant1, $contestant2]);
        yield $battlefield->presentParticipants();

        $currentTurn = $this->turnService->createTurn(...$this->turnService->determineFirstTurnOrder($contestant1, $contestant2));
        do {
            $currentTurn->play();
            $battlefield->addTurn($currentTurn);

            yield $currentTurn;
            $currentTurn = $this->turnService->nextTurn($currentTurn);
        } while ($currentTurn);

        return $battlefield;
    }
}
