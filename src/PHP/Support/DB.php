<?php


namespace Fort\PHP\Support;

use Fort\PHP\Environment;
use PDO;



class DB extends Environment implements DBInterface
{
    use Contracts;

    /**
     * Connect to the database set in the .env file
     * </p>
     * @return mixed returns the database connection instance
     */

    public static function connect():mixed
    {
        return  Contracts::connection();
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
         return self::updateSingleRecord($table,$id, $attributes);
    }


    /**
     * Select a single database table.
     *
     * @return mixed

     */

    public static function table(string $table): mixed
    {


    }


    /**
     * Begin database transaction.
     * This enables you to catch errors if any server problems occurs
     * during database manipulation
     * @return mixed
     */

    public static function beginTransaction(): mixed
    {
        return Contracts::startTransaction();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */
    public static function commit(): mixed
    {
        return Contracts::commitTransaction();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */

    public static function rollBack(): mixed
    {
        return Contracts::rollBackTransaction();
    }


}