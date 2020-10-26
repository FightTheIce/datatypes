<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\DataTypeInterface;
use FightTheIce\Datatypes\Core\Macroable;
use FightTheIce\Datatypes\Core\StringInterface;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\UnicodeString;

class Hash_ implements DataTypeInterface {
    protected $algo   = null;
    protected $data   = null;
    protected $hashed = null;

    public function __construct(string $algo, string $data, bool $raw_output = false) {
        if (!in_array($algo, hash_algos())) {
            throw new \ErrorException('Algo is not valid');
        }

        $this->algo   = $algo;
        $this->data   = $data;
        $this->hashed = new String_(hash($algo, $data, $raw_output));
    }

    public function changeAlgo(string $algo, bool $raw_output = false) {
        self::__construct($algo, $this->data, $raw_output);
    }

    public function getHash() {
        return $this->hashed;
    }

    public function __toString() {
        return $this->hashed->__toString();
    }
}