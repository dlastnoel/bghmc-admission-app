<?php

namespace App\Contracts\Queries;

use Illuminate\Support\Collection;

interface Executable
{
    /**
     * Filters data using queries received from request.
     * This will be used as a sub-filter alongside filters.
     * 
     * @param  string
     */
    public static function execute($primary, $context): Collection;
}
