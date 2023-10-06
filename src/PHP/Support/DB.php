<?php


namespace Fort\PHP\Support;
use Fort\PHP\Builders\QueryBuilders as Builder;

use PDO;
/**
 * @method static mixed connect()
 * @method static mixed insert(string $table, $attributes = [])
 * @method static string|null update(string $table, int|string $id, $attributes = [])
 * @method static mixed beginTransaction()
 * @method static mixed commit()
 * @method static mixed rollBack()
 */

class DB extends Fort
{
    protected static $table;
    protected static $query;
    protected $column;


    /**
     *
     * Select a single database table.
     * @param string $table
     * @return mixed
     */

    public static function table(string $table)
    {
        self::$table = $table;
        return new self();
    }


    public function select($column)
    {
        if (is_array($this->column)) {
            $this->column = implode(',', $this->column);
        }else{
            $this->column = $column;
        }
        $tab = self::$table;
        self::$query = $this->query("SELECT $this->column FROM $tab");
        return $this;
    }

    public function all()
    {
        return $this->fromAll(self::$table)->fetchAll(PDO::FETCH_ASSOC);

    }

    public function where(string $column, $operator, $value = null): static
    {
        $table = self::$table;
        self::$query = $this->query("SELECT * FROM $table WHERE $column $operator $value");
        return $this;
    }


    public static function rawQuery(string $query)
    {
        self::$query = self::connection()->query("$query");
        return new self();
    }

    public function get()
    {
        return self::$query == null ? '[Empty Array ()]' : self::$query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function orderBy(string $column, string $direction)
    {
        $table = self::$table;
        self::$query = self::query("SELECT * FROM $table ORDER BY $column $direction");
        return $this;
    }


    public function max(string $column)
    {
        return $this->MAX_COL($column, self::$table)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function min(string $column)
    {
        return $this->MIN_COL($column, self::$table)->fetchAll(PDO::FETCH_COLUMN);
    }



}