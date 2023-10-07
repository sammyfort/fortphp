<?php


namespace Fort\PHP\Support;
use Fort\PHP\Contracts\Database\Fort as Component;



/**
 * @method static mixed connect()
 * @method static mixed insert(string $table, $attributes = [])
 * @method static string|null update(string $table, int|string $id, $attributes = [])
 * @method static mixed beginTransaction()
 * @method static mixed commit()
 * @method static mixed table(string $table)()
 * @method  where(string $column, $operator, $value = null)
 * @method orderBy(string $column, string $direction)
 * @method orWhere(string $column, $operator, $value = null)
 * @method sum($column)
 * @method max(string $column)
 * @method select($column)
 * @method all()
 * @method static rawQuery(string $query)
 * @method get()
 * @method first()
 * @method whereNull(string $column)
 * @method whereNotNull(string $column)
 * @method min(string $column)
 * @method static mixed rollBack()
 */


class DB extends Component
{
    protected static function __forwardCalls():string
    {
        return 'static';
    }

}