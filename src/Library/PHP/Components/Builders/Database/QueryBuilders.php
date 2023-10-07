<?php


namespace Fort\PHP\Builders\Database;


use Fort\PHP\Contracts\Processor as DBContract;
use PDO;

trait QueryBuilders
{
    use DBContract;

    protected static function boot(){
        return self::connection();

    }

    protected function query($query){
        return $this->boot()->query($query);
    }

    protected function MIN_COL($column, $table){
        return $this->query("SELECT MIN($column) FROM $table");
    }

    protected function MAX_COL($column, $table){
        return $this->query("SELECT MAX($column) FROM $table");
    }

    protected function fromAll($table){

        return $this->query("SELECT * FROM $table");
    }

    protected function counter($table){

        return $this->query("SELECT COUNT(*)FROM $table");
    }

    protected function sumColumn($table, $column){

        return $this->query("SELECT SUM($column)FROM $table");
    }
}