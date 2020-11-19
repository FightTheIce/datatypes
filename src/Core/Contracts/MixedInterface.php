<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface MixedInterface extends PseudoInterface
{
    /**
     * __toMixed.
     *
     * @return mixed
     */
    public function __toMixed();

    public function isCallable(): BooleanInterface;

    public function isArray(): BooleanInterface;

    public function isIterable(): BooleanInterface;

    public function isObject(): BooleanInterface;

    public function isBoolean(): BooleanInterface;

    public function isInteger(): BooleanInterface;

    public function isFloat(): BooleanInterface;

    public function isString(): BooleanInterface;

    public function isNull(): BooleanInterface;

    public function isResource(): BooleanInterface;

    public function isStandardString(): BooleanInterface;

    public function isUnicodeString(): BooleanInterface;

    public function isEmpty(): BooleanInterface;

    public function isScalarType(): BooleanInterface;

    public function isNumeric(): BooleanInterface;

    public function isClosure(): BooleanInterface;

    public function isCompoundType(): BooleanInterface;

    public function isPseudoType(): BooleanInterface;

    public function isSpecialType(): BooleanInterface;

    /**
     * resolve.
     *
     * @return mixed
     */
    public function resolve();
}
