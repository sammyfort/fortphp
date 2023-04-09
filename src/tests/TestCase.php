<?php

namespace Fort\Php\tests\Unit;

use Fort\Php\Global\Laravel\Base;
use Fort\Php\Global\Laravel\EloquentFilters;

abstract class TestCase extends Base
{
    use EloquentFilters;
}
