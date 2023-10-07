<?php


namespace Fort\PHP\Testing;

use Fort\PHP\Str;
use Fort\PHP\Support\DB;


class Tester
{
    public function test(){
       DB::table('users')->select('name','=','')->get();
       // DB::rawQuery('');
        Str::replace('');

    }


}