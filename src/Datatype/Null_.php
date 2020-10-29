<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Null_ implements DatatypeInterface {
    use Macroable;

    public function getType(): string {
        return 'null';
    }

    public function getValue() {
        return null;
    }

    /**
     * compare
     * @param  mixed       $comparator
     * @param  bool|boolean $strict
     * @return bool
     */
    public function compare($comparator, bool $strict = true): bool {
        if ($strict === true) {
            return $this->hardCompare($comparator);
        }

        return $this->softCompare($comparator);
    }

    /**
     * softCompare
     * @param  mixed $comparator
     * @return bool
     */
    public function softCompare($comparator): bool {
        if ($comparator == null) {
            return true;
        }

        return false;
    }

    /**
     * hardCompare
     * @param  mixed $comparator
     * @return bool
     */
    public function hardCompare($comparator): bool {
        if ($comparator === null) {
            return true;
        }

        return false;
    }

    /**
     * strictCompare
     * @param  mixed $comparator
     * @return bool
     */
    public function strictCompare($comparator): bool {
        return $this->hardCompare($comparator);
    }

    public function refresh() {
        return $this;
    }
}