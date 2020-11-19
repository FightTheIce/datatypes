<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface ResourceInterface extends SpecialInterface
{
    public function get_type(): StringInterface;

    /**
     * __toResource.
     *
     * @return mixed
     */
    public function __toResource();
}
