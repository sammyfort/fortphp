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
     * @return PDO returns the database connection instance
     */

    public static function connect(): PDO
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
     * @return string|null
     */

    public static function insert(string $table, $attributes = []): ?string
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

     */

    public static function table(string $table): ?string
    {


    }


    /**
     * Begin database transaction.
     * This enables you to catch errors if any server problems occurs
     * during database manipulation
     * @return ?bool
     */

    public static function beginTransaction(): ?bool
    {
        return Contracts::startTransaction();
    }

    /**
     * Commit database transaction.
     * @return ?bool
     */
    public static function commit(): ?bool
    {
        return Contracts::commitTransaction();
    }

    /**
     * Commit database transaction.
     * @return ?bool
     */

    public static function rollBack(): ?bool
    {
        return Contracts::rollBackTransaction();
    }


}