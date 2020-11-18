<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use Reflector;

interface ObjectInterface extends CompoundInterface
{
    /**
     * __toObject.
     *
     * @return mixed
     */
    public function __toObject();

    public function getReflection(): Reflector;

    public function getHash(): StringInterface;

    public function getId(): IntegerInterface;
}
