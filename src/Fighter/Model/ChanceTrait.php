<?php


namespace Emag\Fighter\Model;


trait ChanceTrait
{
    public function determineLuck(int $luck): bool
    {
        if ($luck === 0) {
            return false;
        }

        return mt_rand(1, 100) <= $luck;
    }
}
