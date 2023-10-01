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
     * @param array $fillables
     * @param array $bindings
     * @return int
     */

    public static function update(string $table, array $fillables, $bindings = []): int;

    /**
     * Run a delete statement against the database.
     *
     * @param string $query
     * @param  array  $bindings
     * @return int
     */


}