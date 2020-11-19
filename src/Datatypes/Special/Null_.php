<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Contracts\NullInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;

class Null_ implements NullInterface
{
    use Macroable;

    /**
     * __construct.
     *
     * @param mixed $null
     */
    public function __construct($null = null)
    {
        if (!is_null($null)) {
            $exception = new InvalidArgumentException('Parameter $null is expected to be null');
            $exception->setComponentName('datatypes');

            throw $exception;
        }
    }

    /**
     * __toNull.
     *
     * @psalm-return null
     */
    public function __toNull()
    {
        return null;
    }

    public function getPrimitiveType(): string
    {
        return 'null';
    }

    public function getDatatypeCategory(): string
    {
        return 'special';
    }

    public function describe(): string
    {
        return 'null value';
    }

    public function isNull(): BooleanInterface
    {
        return new Boolean_(true);
    }
}
