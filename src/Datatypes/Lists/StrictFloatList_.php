<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Scalar\Float_;
use Illuminate\Support\Traits\Macroable;

class StrictFloatList_ extends Collection 
{
    use Macroable;
    
    public function __construct(array $data = [])
    {
        parent::__construct(T::generic(Float_::class));
        if (empty($data)==false) {
            $this->set($data);
        }
    }
}