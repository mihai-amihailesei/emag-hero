<?php


namespace Emag\Battle\Service;


use Emag\Battle\Model\Contestant;

interface ContestantFactory
{
    public function buildContestant(string $name): Contestant;

}
