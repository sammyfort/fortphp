<?php


namespace Fort\PHP\Builders\Database;


class BuildQueries
{
    protected function performSelectColumnOperation($column){
        if (is_array($column)) {
            return implode(',', $column);
        } else {
            return $column;
        }
    }

    protected static function selectAllFromTable($table): string
    {

        return "SELECT * FROM $table";
    }

    protected function selectColumnFromTable($column, $table): string
    {

        return "SELECT $column FROM $table";
    }

    protected function performWhereOperation($column, $operator, $value = null): string
    {

        return " WHERE $column $operator $value";
    }

    protected function performOrWhereClause(string $column, $operator, $value = null): string
    {
        return " OR $column $operator $value";
    }

    protected function orderByClause(string $column, $direction): string
    {
        return " ORDER BY $column $direction";
    }

    protected function whereNotNullOperation(string $column): string
    {

        return " OR $column IS NOT NULL";

    }

    protected function whereNullOperation(string $column): string
    {
        return " OR $column IS NULL";
    }

}