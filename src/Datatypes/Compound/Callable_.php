<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compound;

use FightTheIce\Datatypes\Core\Contracts\CallableInterface;
use Illuminate\Support\Traits\Macroable;
use Thunder\Nevar\Nevar;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use Closure;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Callable_ implements CallableInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

    /**
     * call.
     *
     * @var callable
     */
    protected $call;

    /**
     * __construct.
     *
     * @param callable|null $call
     */
    public function __construct(?callable $call = null)
    {
        $this->hasConstructorRun();

        if (is_null($call)) {
            $call = 'trim';
        }

        $this->call = $call;
    }

    public function getPrimitiveType(): string
    {
        return 'callable';
    }

    public function getDatatypeCategory(): string
    {
        return 'compound';
    }

    public function describe(): string
    {
        return Nevar::describe($this->call);
    }

    /**
     * __toCallable.
     *
     * @return mixed
     */
    public function __toCallable()
    {
        return $this->call;
    }

    /**
     * resolveCallable.
     *
     * @param array $params
     *
     * @return mixed
     */
    public function resolveCallable(...$params)
    {
        return call_user_func_array($this->call, $params);
    }

    public function is_callable_string(): BooleanInterface
    {
        return new Boolean_(is_string($this->call));
    }

    public function is_callable_array(): BooleanInterface
    {
        return new Boolean_(is_array($this->call));
    }

    public function is_callable_closure(): BooleanInterface
    {
        return new Boolean_($this->call instanceof Closure);
    }
}
