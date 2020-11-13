<?php
/*
This library isn't on packagist... so I copied it straight from:
https://github.com/thunderer/Nevar
*/

namespace Thunder\Nevar;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Nevar
{
    /**
     * descrive
     *
     * @param   mixed  $var
     *
     * @return  string
     */
    public static function describe($var)
    {
        if (is_object($var)) {
            return 'object of class ' . get_class($var);
        } elseif (is_resource($var)) {
            return 'resource of type ' . get_resource_type($var);
        } elseif (is_array($var)) {
            if (empty($var)) {
                return 'empty array';
            }
            if (is_callable($var)) {
                return 'callable array';
            }
            if (array_filter($var, 'is_int', ARRAY_FILTER_USE_KEY)) {
                return 'indexed array';
            }

            return 'associative array';
        } elseif (is_int($var)) {
            if ($var < 0) {
                return 'negative integer';
            }
            if ($var > 0) {
                return 'positive integer';
            }

            return 'zero integer';
        } elseif (is_float($var)) {
            if (is_infinite($var)) {
                return 'infinite float';
            }
            if (is_nan($var)) {
                return 'invalid float';
            }
            if ($var < 0) {
                return 'negative float';
            }
            if ($var > 0) {
                return 'positive float';
            }

            return 'zero float';
        } elseif (is_string($var)) {
            if (empty($var)) {
                return 'empty string';
            }
            if (is_callable($var)) {
                return 'callable string';
            }
            if (is_numeric($var)) {
                return 'numeric string';
            }

            return 'string';
        } elseif (is_bool($var)) {
            return true === $var ? 'boolean true' : 'boolean false';
        } else {
            return 'unknown type';
        }
    }
}
