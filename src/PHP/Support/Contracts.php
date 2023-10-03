<?php


namespace Fort\PHP\Support;


use PDO;
use PDOException;


trait Contracts
{

    /**
     * Connect to the database set in the .env file
     * </p>
     * @throws  ?PDO returns the database connection instance
     */

    public static function connection(): PDO
    {
        try {
            $handle = new PDO(
                "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE') .";charset=utf8mb4",
                env('DB_USER'),
                env('DB_PASSWORD'));
            $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $handle;
        } catch (PDOException $e) {
            throw new PDOException("Could not connect to database {$e->getMessage()}");
        }
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



    public static function create(string $table, $attributes = []) : ?string
    {
        $columns = implode(',', array_keys($attributes));
        $values = implode(',', array_fill(0, count($attributes), '?'));
        $stmt = self::connection()->prepare(query: "INSERT INTO $table ($columns) VALUES ($values)");
        return $stmt->execute(array_values($attributes));
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

    public static function updateSingleRecord(string $table, int|string $id, $attributes = []): ?string
    {
        $setPart = array();
        $bindings = array();
        foreach ($attributes as $key => $value) {
            $setPart[] = "$key = :$key";
            $bindings[":$key"] = $value;
        }
        $bindings[":id"] = $id;
        $sql = "UPDATE $table SET " . implode(', ', $setPart) . " WHERE ID = :id";
        $stmt = self::connection()->prepare($sql);
        return $stmt->execute($bindings);
    }

    /**
     * Begin database transaction.
     * This enables you to catch errors if any server problems occurs
     * during database manipulation
     * @return ?bool
     */

    public static function startTransaction():?bool
    {

        return self::connection()->beginTransaction();
    }

    /**
     * Commit database transaction.
     * @return ?bool
     */

    public static function commitTransaction(): ?bool
    {
        return self::connection()->commit();
    }

    /**
     * Commit database transaction.
     * @return ?bool
     */

    public static function rollBackTransaction():?bool
    {
        return self::connection()->rollBack();
    }

}