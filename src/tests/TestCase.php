<?php

namespace Fort\Illuminate\tests;

use Fort\Illuminate\Support\Laravel\Base;
use Fort\Illuminate\Support\Laravel\EloquentFilters;

abstract class TestCase extends Base
{
    use EloquentFilters;
}
