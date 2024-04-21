<?php

namespace App\Http\Queries;

use App\Contracts\Queries\Executable;
use App\Models\Ward;
use Illuminate\Support\Collection;

class WardQuery implements Executable
{

    public static function execute($primary = null, $context = null): Collection
    {
        $wards = collect();

        if ($primary || $context) {

            $wards = Ward::withCount(['admissions' => function ($query) {

                $query->admitted();
            }])

                ->when($primary && !$context, function ($query) use ($primary) {

                    $query->where('id', $primary);
                })

                ->when($context && !$primary, function ($query) use ($context) {
                    $query->filter($context);
                })

                ->orderBy('name', 'ASC')
                ->limit(5)
                ->get();
        }

        return $wards;
    }
}
