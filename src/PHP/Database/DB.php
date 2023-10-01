<?php /** @noinspection PhpToStringImplementationInspection */


namespace Fort\PHP\Database;
use Closure;
use Exception;
use Fort\Exception\DBException;
use Fort\PHP\Environment;
use PDO;
use PDOException;

class DB extends Environment implements DBInterface
{

    public static function connect(): PDO|string
    {
        try {
            $handle = new PDO(
                "mysql:host=".self::HOST.";dbname=".self::DATABASE,
                self::USER,
                self::PASSWORD,
                self::DATABASE);
            $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $handle;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Run an insert statement against the database.
     *
     * @param string $table
     * @param array $attributes
     * @return string|null
     * @throws DBException
     */

    public static function insert(string $table, $attributes = []): ?string
    {
        try {
            self::connect()->beginTransaction();
            $columns = implode(',', array_keys($attributes));
            $values = implode(',', array_fill(0, count($attributes), '?'));
            $stmt = self::connect()->prepare(query: "INSERT INTO $table ($columns) VALUES ($values)");
            $stmt->execute(array_values($attributes));
            self::connect()->commit();
        }
        catch (Exception $e) {
            self::connect()->rollback();
            if ($e instanceof DBException) {
                throw new DBException('Invalid database attribute provided');
            }
            return $e->getMessage();
        }
        return null;
    }

    public static function update(string $table, array $fillables, $bindings = []): int
    {
        $set = [];
        foreach ($bindings as $column) {
            if (!in_array($column, $fillables)) {
                continue;
            }
            $set[] = "$column = :$column";
        }
        $set = implode(", ", $set);
        $stmt = self::connect()->prepare(query: "UPDATE $table SET $set WHERE id = :id");
        $stmt->execute($fillables);
        return $stmt;
    }



}