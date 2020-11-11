<?php

namespace FightTheIce\Datatypes\Functions;

function file_exists(string $filename): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\file_exists($filename));
}

function class_exists(string $class_name, bool $autoload = true): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\class_exists($class_name, $autoload));
}

function class_alias(string $original, string $alias, bool $autoload = true): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\class_alias($$original, $alias, $autoload));
}

/**
 * method_exists.
 *
 * @param mixed  $object
 * @param string $method_name
 *
 * @return \FightTheIce\Datatypes\Scalar\Boolean_
 */
function method_exists($object, string $method_name): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\method_exists($object, $method_name));
}

/**
 * spl_object_hash.
 *
 * @param mixed $obj
 *
 * @return \FightTheIce\Datatypes\Scalar\String_
 */
function spl_object_hash($obj): \FightTheIce\Datatypes\Scalar\String_
{
    return new \FightTheIce\Datatypes\Scalar\String_(\spl_object_hash($obj));
}

/**
 * spl_object_id.
 *
 * @param mixed @obj
 *
 * @return \FightTheIce\Datatypes\Scalar\Integer_
 */
function spl_object_id($obj): \FightTheIce\Datatypes\Scalar\Integer_
{
    return new \FightTheIce\Datatypes\Scalar\Integer_(\spl_object_id($obj));
}

/**
 * is_empty.
 *
 * @param mixed var
 *
 * @return \FightTheIce\Datatypes\Scalar\Boolean_
 */
function is_empty($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(empty($var));
}

/**
 * gettype.
 *
 * @param mixed $var
 *
 * @return \FighttheIce\Datatypes\Scalar\String_
 */
function gettype($var): \FighttheIce\Datatypes\Scalar\String_
{
    return new \FighttheIce\Datatypes\Scalar\String_(\gettype($var));
}

function is_null($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_null($var));
}

function is_string($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_string($var));
}

function is_scalar($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_scalar($var));
}

function is_float($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_float($var));
}

function is_int($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_int($var));
}

function is_bool($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_bool($var));
}

function is_object($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_object($var));
}

function is_array($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_array($var));
}

function is_numeric($var): \FightTheIce\Datatypes\Scalar\Boolean_
{
    return new \FightTheIce\Datatypes\Scalar\Boolean_(\is_numeric($var));
}

function get_class($object): \FighttheIce\Datatypes\Scalar\String_
{
    return new \FighttheIce\Datatypes\Scalar\String_(\get_class($object));
}

function strlen(string $string): \FightTheIce\Datatypes\Scalar\Integer_
{
    return new \FightTheIce\Datatypes\Scalar\Integer_(\strlen($string));
}

function strtolower(string $string): \FighttheIce\Datatypes\Scalar\String_
{
    return new \FighttheIce\Datatypes\Scalar\String_(strtolower($string));
}
