<?php


namespace Fort\PHP\Support\Testing;
use Fort\PHP\Support\DB;

class Tester
{
    public function test(){
     //  DB::table('users')->where('name','=','')->get();
       // DB::rawQuery('');
        config('database.DB_DATABASE');
    }


}