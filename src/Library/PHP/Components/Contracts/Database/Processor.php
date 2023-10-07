<?php


namespace Fort\PHP\Contracts\Database;


use PDO;
use PDOException;
use Dotenv\Dotenv;


trait Processor
{

    /**
     * Connect to the database set in the .env file
     * </p>
     * @return mixed returns the database connection instance
     */


    protected static function connection(): mixed
    {

        try {
            $handle = new PDO(
                "mysql:host=" . $_ENV["DB_HOST"] . ";dbname=" . $_ENV["DB_DATABASE"] . ";charset=utf8mb4",
                $_ENV["DB_USER"],
                $_ENV["DB_PASSWORD"]);
            $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $handle;
        } catch (PDOException $e) {
            return "Cannot connect to database: {$e->getMessage()}";
        }
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


    protected static function create(string $table, $attributes = []): mixed
    {
        try {
            $columns = implode(',', array_keys($attributes));
            $values = implode(',', array_fill(0, count($attributes), '?'));
            $stmt = self::connection()->prepare(query: "INSERT INTO $table ($columns) VALUES ($values)");
            return $stmt->execute(array_values($attributes));
        }

        catch (PDOException $exception){
            return "Cannot perform database operation INSERT: {$exception->getMessage()}";
        }

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
     * @return mixed
     */

    protected static function updateSingleRecord(string $table, int|string $id, $attributes = []): mixed
    {
        try {
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
        catch (PDOException $exception){
            return "Cannot perform database operation UPDATE: {$exception->getMessage()}";
        }
    }

    /**
     * Begin database transaction.
     * This enables you to catch errors if any server problems occurs
     * during database manipulation
     * @return mixed
     */

    protected static function startTransaction(): mixed
    {

        return self::connection()->beginTransaction();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */

    protected static function commitTransaction(): mixed
    {
        return self::connection()->commit();
    }

    /**
     * Commit database transaction.
     * @return mixed
     */

    protected static function rollBackTransaction(): mixed
    {
        return self::connection()->rollBack();
    }

}