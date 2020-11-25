<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Complex;

use FightTheIce\Datatypes\Core\Contracts\UuidInterface;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface as RUuidInterface;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Scalar\NumberString_;
use FightTheIce\Exceptions\InvalidArgumentException;

class Uuid_ implements UuidInterface
{
    use Macroable;

    /**
     * uuidObj.
     *
     * @var mixed
     */
    protected $uuidObj;

    /**
     * __construct.
     *
     * @param mixed $seed
     */
    public function __construct($seed = null)
    {
        if (is_null($seed)) {
            //generate a uuid
            $this->uuidObj = Uuid::uuid6();
        } else {
            if (is_numeric($seed)) {
                $seed = (string) $seed;

                $this->uuidObj = Uuid::fromInteger($seed);
            } elseif (is_string($seed)) {
                $this->uuidObj = Uuid::fromString($seed);
            } else {
                $exception = new InvalidArgumentException('Parameter $seed is required to be a string or null');
                $exception->setComponentName('datatypes');

                throw $exception;
            }
        }
    }

    public function __toUuid(): string
    {
        return $this->uuidObj->__toString();
    }

    public function getDatatypeCategory(): string
    {
        return 'complex';
    }

    public function describe(): string
    {
        return 'uuid';
    }

    public function getPrimitiveType(): string
    {
        return 'string';
    }

    public function getIntegerString(): StringInterface
    {
        return new NumberString_($this->uuidObj->getInteger()->__toString());
    }

    public function getUuidObj(): RUuidInterface
    {
        return $this->uuidObj;
    }
}
