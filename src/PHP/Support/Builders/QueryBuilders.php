<?php


namespace Fort\PHP\Builders;


use Fort\PHP\Support\Contracts;
use Fort\PHP\Support\Fort;
use PDO;

trait QueryBuilders
{
    use Contracts;
    public function boot(){
        return self::connection();

    }

    public function query($query){
        return $this->boot()->query($query);
    }

    public function MIN_COL($column, $table){
        return $this->query("SELECT MIN($column) FROM $table");
    }

    public function MAX_COL($column, $table){
        return $this->query("SELECT MAX($column) FROM $table");
    }

    public function fromAll($table){

        return $this->query("SELECT * FROM $table");
    }
}