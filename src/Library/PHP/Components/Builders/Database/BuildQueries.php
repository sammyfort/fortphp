<?php


namespace Fort\PHP\Builders\Database;


class BuildQueries
{
    public function performSelectColumnOperation($column){
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

    public function selectColumnFromTable($column, $table): string
    {

        return "SELECT $column FROM $table";
    }

    public function performWhereOperation($column, $operator, $value = null): string
    {

        return " WHERE $column $operator $value";
    }

    public function performOrWhereClause(string $column, $operator, $value = null): string
    {
        return " OR $column $operator $value";
    }

    public function orderByClause(string $column, $direction): string
    {
        return " ORDER BY $column $direction";
    }

    public function whereNotNullOperation(string $column): string
    {

        return " OR $column IS NOT NULL";

    }

    public function whereNullOperation(string $column): string
    {
        return " OR $column IS NULL";
    }

}