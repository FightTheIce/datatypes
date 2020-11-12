<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\String_ as NonUnicodeString_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;

class String_ implements DatatypeInterface, ResolvableInterface
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    protected string $string;
    protected DatatypeInterface $class;
    protected bool $isUnicode = false;

    public function __construct(string $obj = '')
    {
        $this->string = $obj;

        if (strlen($obj) != strlen(utf8_decode($obj))) {
            //unicode
            $this->class = new UnicodeString_($obj);
            $this->isUnicode = true;
        } else {
            //no unicode
            $this->class = new NonUnicodeString_($obj);
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->string;
    }

    public function getDatatypeClass(): DatatypeInterface
    {
        return $this->class;
    }

    public function isUnicode(): bool {
        return $this->isUnicode;
    }

    /**
     * resolve.
     *
     * @return mixed
     */
    public function resolve()
    {
        return $this->getDatatypeClass();
    }
}
