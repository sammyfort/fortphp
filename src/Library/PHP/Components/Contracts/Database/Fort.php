<?php
/** @noinspection PhpMissingFieldTypeInspection */



namespace Fort\PHP\Contracts\Database;

use Exception;
use Fort\Exception\LogicException;
use Fort\PHP\Builders\Database\BuildQueries;
use Fort\PHP\Builders\Database\QueryBuilders as Builder;
use Fort\PHP\Contracts\Http\HttpRequests as HttpRequest;

use PDO;

abstract class Fort extends BuildQueries
{
    use Processor, Builder, HttpRequest ;

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
     * * @method table()
     * @param string $table
     * @return Fort
     */

    public static function table(string $table): static
    {
        self::$table = $table;
        self::$query .= self::selectAllFromTable($table);
        return new static();
    }

    /**
     *
     * Select a database column and interact with.
     * @method select(string $column)
     * @param string $column
     * @return self
     */

    public function select(string $column): self
    {
        $this->column = $this->performSelectColumnOperation($column);
        self::$query = $this->selectColumnFromTable($this->column, self::$table);
        return $this;
    }

    /**
     *
     * Select a single database table.
     * @method all()
     * @return array
     */

    public function all():  array
    {
        return $this->fromAll(self::$table)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     * Chain a where method to database query.
     * @return mixed
     */
    public function where(string $column, $operator, $value = null): self
    {
        self::$query .= $this->performWhereOperation($column, $operator, $value);
        return $this;
    }

    /**
     *
     * Chain a orWhere method to database query.
     * @param string $column
     * @param $operator
     * @param null $value
     * @return self
     */

    public function orWhere(string $column, $operator, $value = null): self
    {
        self::$query .= $this->performOrWhereClause($column, $operator, $value);
        return $this;
    }

    /**
     *
     * Chain a whereNull method to database query.
     * @param string $column
     * @return self
     */

    public function whereNull(string $column): self
    {
        self::$query .= $this->whereNullOperation($column);
        return $this;
    }

    /**
     *
     * Chain a whereNull method to database query.
     * @param string $column
     * @return self
     */

    public function whereNotNull(string $column): self
    {
        self::$query .= $this->whereNotNullOperation($column);
        return $this;
    }


    /**
     *
     * Perform a raw sql query with is method and chain a ->get() to get results.
     * @param string $query
     * @return self
     */

    public static function rawQuery(string $query):self
    {
        self::$query = $query;
        return new static();
    }

    /**
     *
     * Get the result set of the database query.
     * @param null $return_type
     * @return array|string
     */

    public function get($return_type = null): array|string
    {
        try {
            return $this->query(self::$query)->fetchAll($return_type == 'object' ? PDO::FETCH_OBJ : PDO::FETCH_ASSOC);
        }
        catch (Exception $exception){
            return  $exception->getMessage();
        }
    }

    /**
     *
     * Get the first result set of the database query.
     * @return array|string
     */

    public function first(): array|string
    {
        try {
            return $this->query(self::$query)->fetchAll(PDO::FETCH_ORI_FIRST);
        }
        catch (Exception $exception){
            return  $exception->getMessage();
        }
    }

    /**
     *
     * Add order by to the database query.
     * @param string $column
     * @param string $direction
     * @return self
     */

    public function orderBy(string $column, string $direction):self
    {
        self::$query .= $this->orderByClause($column, $direction);
        return $this;
    }


    /**
     *
     * Get the maximum number of a column.
     * @param string $column
     * @return array
     */

    public function max(string $column): array
    {
        return $this->MAX_COL($column, self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     *
     * Count records of a table.
     * @return array
     */

    public function count(): array
    {
        return $this->counter(self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     *
     * Sum all all records in the specified column.
     * @param $column
     * @return array
     */

    public function sum($column): array
    {
        return $this->sumColumn(self::$table, $column)->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     *
     * Get the minimum number of a column.
     * @param string $column
     * @return array
     */

    public function min(string $column): array
    {
        return $this->MIN_COL($column, self::$table)
            ->fetchAll(PDO::FETCH_COLUMN);
    }



}