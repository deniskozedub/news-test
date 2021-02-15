<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class Tags extends Filter
{
    protected function applyFilter(Builder $builder): Builder
    {
        $tags = explode(',',request()->get($this->filterName()));
        return $builder->whereHas($this->filterName(),function ($query) use ($tags){
            $query->whereIn('tag_id',$tags);
        });
    }
}
