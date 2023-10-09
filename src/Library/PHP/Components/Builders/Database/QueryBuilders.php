<?php


namespace Fort\PHP\Builders\Database;

use Fort\PHP\Contracts\Database\Processor;
use PDO;
use PDOStatement;


trait QueryBuilders
{
    use Processor;

    protected static function boot(): PDO|string
    {
        return self::connection();

    }

    protected function query($query): bool|PDOStatement
    {
        return $this->boot()->query($query);
    }

    protected function MIN_COL($column, $table): bool|PDOStatement
    {
        return $this->query("SELECT MIN($column) FROM $table");
    }

    protected function MAX_COL($column, $table): bool|PDOStatement
    {
        return $this->query("SELECT MAX($column) FROM $table");
    }

    protected function fromAll($table): bool|PDOStatement
    {

        return $this->query("SELECT * FROM $table");
    }

    protected function counter($table): bool|PDOStatement
    {

        return $this->query("SELECT COUNT(*) FROM $table");
    }

    protected function sumColumn($table, $column): bool|PDOStatement
    {

        return $this->query("SELECT SUM($column) FROM $table");
    }
}