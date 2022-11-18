<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QueryFilter
{
    public Request $request;
    protected $builder;
    protected string $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters(): array|string|null
    {
        return $this->request->query();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $name = Str::camel($name);

            if(method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    protected function paramToArray($param)
    {
        return explode($this->delimiter, $param);
    }
}
