<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Scalar\Boolean_;
use Illuminate\Support\Traits\Macroable;

class BooleanList_ extends Collection 
{
    use Macroable;
    
    public function __construct(array $data = [])
    {
        parent::__construct(T::union(T::boolean(),T::generic(Boolean_::class)));
        if (empty($data)==false) {
            $this->set($data);
        }
    }
}