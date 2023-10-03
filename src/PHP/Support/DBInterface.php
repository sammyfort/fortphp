<?php


namespace Fort\PHP\Support;


use PDO;

interface DBInterface
{
    /**
     * Run connection to the database .
     *

     * @return mixed
     */

      public static function connect():mixed;

    /**
     * Run an insert statement against the database.
     *
     * @param string $table
     * @param  array  $attributes
     * @return mixed
     */
    public static function insert(string $table, $attributes = []):mixed;

    /**
     * Run an update statement against the database.
     *
     * @param string $table
     * @param int $id
     * @param array $attributes
     * @return mixed
     */

    public static function update(string $table, int $id, $attributes = []): mixed;


    /**
     * Select a single database table.
     *

     */

    public static function table(string $table): mixed;


    /**
     * Begin a database transaction in the database.
     *
     * @return mixed
     */

    public static function beginTransaction(): mixed;

    /**
     * commit a transaction in the database.
     *
     * @return mixed
     */

    public static function commit(): mixed;

    /**
     * Rollback a transaction in the database.
     *
     * @return mixed
     */

    public static function rollBack(): mixed;


}