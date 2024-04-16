<?php

namespace App\Contracts\Filters;

interface Filterable
{
    /**
     * Transforms model query based on request
     */
    public static function get();
}
