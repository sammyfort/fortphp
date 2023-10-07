<?php
/** @noinspection PhpMissingFieldTypeInspection */



namespace Fort\PHP\Contracts\Database;

use Fort\Exception\LogicException;
use Fort\PHP\Builders\Database\BuildQueries;
use Fort\PHP\Builders\Database\QueryBuilders as Builder;

use PDO;

abstract class Fort extends BuildQueries
{
    use Processor, Builder;

    /**
     * @property string $table
     * Database table we are talking to
     *
     */
    protected static $table;

    /**
     * @property string $query
     * Database query to return
     *
     */
    protected static $query = '';

    /**
     * @property string $column
     * Database column we want to select
     *
     */
    protected $column;



    /**
     * Connect to the database set in the .env file
     * </p>
     * @return mixed returns the database connection instance
     */


    public static function connect(): mixed
    {
        return self::connection();
    }

    /**
     * Run an insert statement against the database.
     *
     * @param string $table
     * The database table where you are storing the new record
     * @param array $attributes
     * array keys of table columns and array values of the binding
     * @return mixed
     */

    public static function insert(string $table, $attributes = []): mixed
    {
        return self::create($table, $attributes);
    }

    /**
     * Run an update statement against the database.
     *
     * @param string $table
     * The database table where you are storing the new record
     *  * @param int|string $id
     * The primary key of the column you are attempting to update
     * @param array $attributes
     * array keys of table columns and array values of the binding
     * @return string|null
     */
    public static function update(string $table, int|string $id, $attributes = []): ?string
    {
        return self::updateSingleRecord($table, $id, $attributes);
    }


    /**
     * Begin database transaction.
     * This enables you to catch errors if any server problems occurs
     * during database manipulation
     * @return mixed
     */

    public static function beginTransaction(): mixed
    {
        return self::startTransaction();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */
    public static function commit(): mixed
    {
        return self::commitTransaction();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */

    public static function rollBack(): mixed
    {
        return self::rollBackTransaction();
    }

    /**
     * @throws LogicException
     */
    protected static function __forwardCalls()
    {
        throw new LogicException('Invalid syntax call', 500);
    }

    /**
     *
     * Select a single database table.
     * @param string $table
     * @return Fort
     */


    public static function table(string $table)
    {
        self::$table = $table;
        self::$query .= self::selectAllFromTable($table);
        return new static();
    }


    public function select($column)
    {
        $this->column = $this->performSelectColumnOperation($column);
        self::$query = $this->selectColumnFromTable($this->column, self::$table);
        return $this;
    }

    public function all()
    {
        return $this->fromAll(self::$table)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function where(string $column, $operator, $value = null): static
    {

        self::$query .= $this->performWhereOperation($column, $operator, $value);

        return $this;
    }

    public function orWhere(string $column, $operator, $value = null): static
    {
        self::$query .= $this->performOrWhereClause($column, $operator, $value);

        return $this;
    }

    public function whereNull(string $column): static
    {
        self::$query .= $this->whereNullOperation($column);

        return $this;
    }

    public function whereNotNull(string $column): static
    {
        self::$query .= $this->whereNotNullOperation($column);
        return $this;
    }


    public static function rawQuery(string $query)
    {
        self::$query = $query;
        return new static();
    }

    public function get()
    {
        return $this->query(self::$query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        return $this->query(self::$query)->fetchAll(PDO::FETCH_UNIQUE);
    }

    public function orderBy(string $column, string $direction)
    {

        self::$query .= $this->orderByClause($column, $direction);
        return $this;
    }


    public function max(string $column)
    {
        return $this->MAX_COL($column, self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    public function count()
    {
        return $this->counter(self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);

    }

    public function sum($column)
    {
        return $this->sumColumn(self::$table, $column)->fetchAll(PDO::FETCH_COLUMN);

    }

    public function min(string $column)
    {
        return $this->MIN_COL($column, self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);
    }

}