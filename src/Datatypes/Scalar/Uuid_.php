<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;

class Uuid_ implements DatatypeInterface
{
    use Macroable;

    const UUID1 = 1;
    const UUID4 = 4;
    const UUID6 = 6;

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
     * @param int   $preference
     */
    public function __construct($uuid = null, int $preference = 6)
    {
        if (is_null($uuid)) {
            //this means we need to generate one
            $this->generateUuid($preference);
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
     * @param int $type
     *
     */
    private function generateUuid(int $type): void
    {
        switch ($type) {
            case self::UUID1:
                $this->uuidObj = Uuid::uuid1();
            break;

            case self::UUID4:
                $this->uuidObj = Uuid::uuid4();
            break;

            case self::UUID6:
                $this->uuidObj = Uuid::uuid6();
            break;

            default:
                $this->uuidObj = Uuid::uuid6();
            break;
        }
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
    public function getInteger()
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
