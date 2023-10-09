<?php


namespace Fort\PHP\Builders\Database;


class BuildQueries
{
    /**
     *
     * select column from database.
     * @param $column
     * @return mixed
     */

    protected function performSelectColumnOperation($column): mixed
    {
        if (is_array($column)) {
            return implode(',', $column);
        } else {
            return $column;
        }
    }

    /**
     *
     * sselect all from the specified table.
     * @param $table
     * @return string
     */

    protected static function selectAllFromTable($table): string
    {

        return "SELECT * FROM $table";
    }

    /**
     *
     * select column from database table.
     * @param $column
     * @param $table
     * @return string
     */

    protected function selectColumnFromTable($column, $table): string
    {

        return "SELECT $column FROM $table";
    }

    /**
     *
     * Perform where operation from database.
     * @param $column
     * @param $operator
     * @param null $value
     * @return string
     */

    protected function performWhereOperation($column, $operator, $value = null)
    {

        return " WHERE $column $operator $value";
    }

    /**
     *
     * Perform or database query operation.
     * @param string $column
     * @param $operator
     * @param null $value
     * @return string
     */

    protected function performOrWhereClause(string $column, $operator, $value = null): string
    {
        return " OR $column $operator $value";
    }

    /**
     *
     * Perform where database operation.
     * @param string $column
     * @param $direction
     * @return string
     */

    protected function orderByClause(string $column, $direction): string
    {
        return " ORDER BY $column $direction";
    }

    /**
     *
     * select column from database.
     * @param string $column
     * @return string
     */

    protected function whereNotNullOperation(string $column): string
    {

        return " OR $column IS NOT NULL";

    }

    /**
     *
     * Perform where whereNull database operation.
     * @param string $column
     * @return string
     */

    protected function whereNullOperation(string $column): string
    {
        return " OR $column IS NULL";
    }

}