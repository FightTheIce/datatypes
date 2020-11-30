<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\VoidInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Void_ implements VoidInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

    public function __construct()
    {
        $this->hasConstructorRun();
    }

    public function __toVoid(): void
    {
    }

    public function isVoid(): BooleanInterface
    {
        return new Boolean_(true);
    }

    public function getPrimitiveType(): string
    {
        return 'void';
    }

    public function getDatatypeCategory(): string
    {
        return 'pseudo';
    }

    public function describe(): string
    {
        return 'void';
    }
}
