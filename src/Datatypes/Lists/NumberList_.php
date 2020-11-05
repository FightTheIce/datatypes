<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ListInterface;

class NumberList_ extends Collection implements ListInterface
{
    use Macroable;

    public function __construct(array $data = [])
    {
        parent::__construct(T::union(T::generic(Number_::class), T::float(), T::integer(), T::generic(Float_::class), T::generic(Integer_::class)));
        if (empty($data) == false) {
            $this->set($data);
        }
    }
}
