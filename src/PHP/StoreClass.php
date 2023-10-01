<?php


namespace Fort\PHP;
use Fort\PHP\Database\DB;

class StoreClass extends DB
{
    public function __construct()
    {
        parent::__construct
        (
            'localhost',
            'sammy',
            'fort_php_package',
            'test123'
        );
    }

    /**
     * @throws \Fort\Exception\DBException
     */
    public function save()
    {
        DB::insert('users', [
            'id'=> 1,
            'name' => 'Fort',
            'age'=> '18',
        ]);
    }

    public function up(){
        DB::update('user', ['name','age'], [
            'name' => 'Sammy',
            'age'=> '19'
        ]);
    }
}