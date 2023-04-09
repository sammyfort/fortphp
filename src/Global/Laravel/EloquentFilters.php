<?php


namespace Fort\Php\Global\Laravel;
use Carbon\Carbon;

trait EloquentFilters
{
    public function scopeToday($model, $column = 'created_at')
    {
        return $model->whereDate($column, Carbon::today());
    }

    public function scopeYesterday($model, $column = 'created_at')
    {
        return $model->whereDate($column, Carbon::yesterday());
    }

    public function scopeMonthToDate($model, $column = 'created_at')
    {
        return $model->whereBetween($column, [Carbon::now()->startOfMonth(), Carbon::now()]);
    }

    public function scopeQuarterToDate($model, $column = 'created_at')
    {
        $now = Carbon::now();
        return $model->whereBetween($column, [$now->startOfQuarter(), $now]);
    }

    public function scopeYearToDate($model, $column = 'created_at')
    {
        return $model->whereBetween($column, [Carbon::now()->startOfYear(), Carbon::now()]);
    }

    public function scopeLast7Days($model, $column = 'created_at')
    {
        return $model->whereBetween($column, [Carbon::today()->subDays(6), Carbon::now()]);
    }

    public function scopeLast30Days($model, $column = 'created_at')
    {
        return $model->whereBetween($column, [Carbon::today()->subDays(29), Carbon::now()]);
    }

    public function scopeLastQuarter($model, $column = 'created_at')
    {
        $now = Carbon::now();
        return $model->whereBetween($column, [$now->startOfQuarter()->subMonths(3), $now->startOfQuarter()]);
    }

    public function scopeLastYear($model, $column = 'created_at')
    {
        return $model->whereBetween($column, [Carbon::now()->subYear(), Carbon::now()]);
    }
}
