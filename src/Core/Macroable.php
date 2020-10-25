<?php

namespace FightTheIce\Datatypes\Core;

use Illuminate\Support\Traits\Macroable as IMacroable;

trait Macroable {
    use IMacroable;

    /**
     * Checks if macro is registered.
     *
     * @param  string  $name
     * @return bool
     */
    public static function getMacroNames() {
        return array_keys(static::$macros);
    }
}