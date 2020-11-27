<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Traits;

trait PreventConstructorFromRunningTwice
{
    protected bool $hasRun = false;

    protected function hasConstructorRun(): void
    {
        if ($this->hasRun === true) {
            throw new \ErrorException('The constructor has already run!');
        }

        if ($this->hasRun === false) {
            $this->hasRun = true;
        }
    }
}
