<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use Thunder\Nevar\Nevar;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;

class Boolean_ implements BooleanInterface
{
    use Macroable;

    protected bool $value = false;

    public function __construct(bool $value = false)
    {
        $this->value = $value;
    }

    public function getDatatypeCategory(): string
    {
        return 'scalar';
    }

    public function describe(): string
    {
        return Nevar::describe($this->value);
    }

    public function getPrimitiveType(): string
    {
        return 'boolean';
    }

    public function isFalse(): bool
    {
        if ($this->value === false) {
            return true;
        }

        return false;
    }

    public function isTrue(): bool
    {
        if ($this->value === true) {
            return true;
        }

        return false;
    }

    public function inverse(): BooleanInterface
    {
        return new self(!$this->value);
    }

    /**
     * transform.
     *
     * @param mixed $trueString
     * @param mixed $falseString
     *
     * @return StringInterface
     */
    public function transform($trueString, $falseString): StringInterface
    {
        if (is_object($trueString)) {
            if (!method_exists($trueString, '__toString')) {
                $exception = new InvalidArgumentException('trueString parameter is expected to be stringable');
                $exception->setComponentName('datatypes');

                throw $exception;
            }

            $trueString = $trueString->__toString();
        }

        if (!is_string($trueString)) {
            $exception = new InvalidArgumentException('trueString parameter is expected to be a string.');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        if (is_object($falseString)) {
            if (!method_exists($falseString, '__toString')) {
                $exception = new InvalidArgumentException('falseString parameter is expected to be stringable');
                $exception->setComponentName('datatypes');

                throw $exception;
            }

            $falseString = $falseString->__toString();
        }

        if (!is_string($falseString)) {
            $exception = new InvalidArgumentException('falseString parameter is expected to be a string.');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        if ($this->value === true) {
            return new String_($trueString);
        }

        return new String_($falseString);
    }

    public function __toBoolean(): bool
    {
        return $this->value;
    }
}
