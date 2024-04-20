<?php

namespace App\Contracts\Queries;

use Illuminate\Support\Collection;

interface Executable
{
    /**
     * Filters data using queries received from request.
     * 
     * This will be used as a sub-filter alongside filters.
     * 
     * @param string $primary
     * @param string $context
     */
    public static function execute(?string $primary, ?string $context): Collection;
}
