<?php

namespace App\Services;

trait Solution
{
    public function getTagSolution(string $tag): ?array
    {
        return $this->tagSolution[$tag]?? null;
    }
}
