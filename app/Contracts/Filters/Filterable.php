<?php

namespace App\Contracts\Filters;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Filterable
{
    /**
     * Transforms model query based on request
     */
    public static function get(): LengthAwarePaginator;
}
