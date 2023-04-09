<?php

namespace Fort\Illuminate\tests;


use Fort\Illuminate\Support\Eloquent\Base;
use Fort\Illuminate\Support\Eloquent\DateFilters;

abstract class TestCase extends Base
{
    use DateFilters;
}
