<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Advanced;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use Ramsey\Uuid\Uuid;
use Stringable;

class Uuid_ implements DatatypeInterface, Stringable
{
    use Macroable;

    protected string $value;

    public function __construct(string $uuid = '')
    {
        if (empty($uuid)) {
            $uuid = Uuid::uuid6()->__toString();
        }

        if (Uuid::isValid($uuid) == false) {
            throw new \ErrorException('Invalid UUID: [' . $uuid . ']');
        }

        $this->value = $uuid;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function uuid1(): self
    {
        return new self(Uuid::uuid1()->__toString());
    }

    public function uuid2(): self
    {
        return new self(Uuid::uuid2(Uuid::DCE_DOMAIN_PERSON)->__toString());
    }

    public function uuid3(string $url = ''): self
    {
        return new self(Uuid::uuid3(Uuid::NAMESPACE_URL, $url)->__toString());
    }

    public function uuid4(): self
    {
        return new self(Uuid::uuid4()->__toString());
    }

    public function uuid5(string $url = ''): self
    {
        return new self(Uuid::uuid5(Uuid::NAMESPACE_URL, $url)->__toString());
    }

    public function uuid6(): self
    {
        return new self(Uuid::uuid6()->__toString());
    }

    public function __toString()
    {
        return $this->value;
    }
}
