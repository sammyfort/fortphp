<?php /** @noinspection PhpToStringImplementationInspection */


namespace Fort\PHP\Database;

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
                "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE .";charset=utf8mb4",
                self::USER,
                self::PASSWORD);
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
     */

    public static function insert(string $table, $attributes = []): ?string
    {
        $columns = implode(',', array_keys($attributes));
        $values = implode(',', array_fill(0, count($attributes), '?'));
        $stmt = self::connect()->prepare(query: "INSERT INTO $table ($columns) VALUES ($values)");
        return $stmt->execute(array_values($attributes));
    }

    public static function update(string $table, int $id, $attributes = []): ?string
    {
        $setPart = array();
        $bindings = array();
        foreach ($attributes as $key => $value) {
            $setPart[] = "{$key} = :{$key}";
            $bindings[":{$key}"] = $value;
        }
        $bindings[":id"] = $id;
        $sql = "UPDATE {$table} SET " . implode(', ', $setPart) . " WHERE ID = :id";
        $stmt = self::connect()->prepare($sql);
        return $stmt->execute($bindings);

    }


    public static function beginTransaction(): ?bool
    {
        return self::connect()->beginTransaction();
    }

    public static function commit(): ?bool
    {
        return self::connect()->commit();
    }

    public static function rollBack(): ?bool
    {
        return self::connect()->rollBack();
    }


}