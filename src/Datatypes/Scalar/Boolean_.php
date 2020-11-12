<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Boolean_ implements DatatypeInterface
{
    use Macroable;

    protected bool $value = false;

    public function __construct(bool $value = false)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        return $this->value;
    }

    public function isTrue(): bool
    {
        if ($this->value === true) {
            return true;
        }

        return false;
    }

    public function isFalse(): bool
    {
        return !$this->isTrue();
    }

    public function inverse(): self
    {
        return new self(!$this->value);
    }

    public function transform(string $true, string $false): string
    {
        if ($this->isTrue()) {
            return $true;
        }

        return $false;
    }
}
