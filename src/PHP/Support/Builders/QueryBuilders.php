<?php


namespace Fort\PHP\Builders;


use Fort\PHP\Support\Contracts;
use Fort\PHP\Support\Fort;
use PDO;

trait QueryBuilders
{
    use Contracts;

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

    protected function summ($table){

        return $this->query("SELECT SUM (*)FROM $table");
    }
}