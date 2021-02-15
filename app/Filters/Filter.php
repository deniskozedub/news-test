<?php


namespace App\Filters;


use Closure;
use Illuminate\Database\Eloquent\Builder;
use Str;

abstract class Filter
{
    public function handle($request, Closure $next)
    {
        if(!request()->has($this->filterName())){
            return $next($request);
        }
        return $this->applyFilter($next($request));
    }

    protected abstract function applyFilter(Builder $builder);

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }
}
