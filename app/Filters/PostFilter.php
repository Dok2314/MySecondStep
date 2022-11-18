<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class PostFilter extends QueryFilter
{
    public function users($ids)
    {
        $this->builder->whereHas('user', fn($q) => $q->whereKey($ids));
    }
}
