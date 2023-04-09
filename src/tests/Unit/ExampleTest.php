<?php

namespace Fort\Php\tests\Feature;

use Fort\Php\Global\Laravel\Base;


class ExampleTest extends Base
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
       User::Today()->get();
    }
}
