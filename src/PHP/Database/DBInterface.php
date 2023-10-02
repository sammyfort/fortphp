<?php


namespace Fort\PHP\Database;


use PDO;

interface DBInterface
{
    /**
     * Run connection to the database .
     *

     * @return PDO|string
     */

      public static function connect():PDO|string;

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
     * @return ?string
     */

    public static function update(string $table, int $id, $attributes = []): ?string;


    /**
     * Begin a database transaction in the database.
     *
     * @return ?bool
     */

    public static function beginTransaction(): ?bool;

    /**
     * commit a transaction in the database.
     *
     * @return ?bool
     */

    public static function commit(): ?bool;

    /**
     * Rollback a transaction in the database.
     *
     * @return ?bool
     */

    public static function rollBack(): ?bool;


}