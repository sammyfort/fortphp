<?php /** @noinspection PhpToStringImplementationInspection */


namespace Fort\PHP\Database;
use Closure;
use Exception;
use Fort\Exception\DBException;
use PDO;
use PDOException;

class DB
{
    protected static ?Closure $pdo;
    protected static string $database;
    protected static string $user;
    protected static string|null $password = '';

    public function __construct($host, $user, $database, $password = null)
    {
        static::$pdo = $host;
        static::$database = $database;
        static::$user = $user;
        static::$password = $password;
    }
    protected static function connect(): PDO|string
    {
        try {
            $query = new PDO(
                "mysql:host=".static::$pdo.";dbname=".static::$database,
                static::$user,
                static::$password,
                static::$database);
            $query->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $query;
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


    public function delete(string $query, $bindings = []): int
    {
        // TODO: Implement delete() method.
    }

}