<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;

class Uuid_ implements DatatypeInterface
{
    use Macroable;

    /**
     * value.
     *
     * @var string
     */
    protected $value = '';

    /**
     * uuidObj.
     *
     * @var mixed
     */
    protected $uuidObj;

    /**
     * __construct.
     *
     * @param mixed $uuid
     */
    public function __construct($uuid = null)
    {
        if (is_null($uuid)) {
            //this means we need to generate one
            $this->generateUuid();
        } else {
            //now we need to "determine" the uuid convert it to a string and check that it is valid
            if (is_numeric($uuid)) {
                if (!is_string($uuid)) {
                    $uuid = (string) $uuid;
                }

                $this->uuidObj = Uuid::fromInteger($uuid);
            } elseif (is_string($uuid)) {
                $this->uuidObj = Uuid::fromString($uuid);
            } else {
                throw new \ErrorException('X');
            }
        }

        $this->value = $this->uuidObj->__toString();
    }

    /**
     * generateUuid.
     *
     */
    private function generateUuid(): void
    {
        $this->uuidObj = Uuid::uuid6();
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * getInteger.
     *
     * @return string
     */
    public function getIntegerString()
    {
        return $this->uuidObj->getInteger()->__toString();
    }

    /**
     * getuuidObj.
     *
     * @return mixed
     */
    public function getUuidObj()
    {
        return $this->uuidObj;
    }

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
