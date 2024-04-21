<?php

namespace App\Http\Filters;

use App\Contracts\Filters\Filterable;
use App\Models\Ward;
use Illuminate\Pagination\LengthAwarePaginator;

class WardFilter implements Filterable
{

    public static function get(): LengthAwarePaginator
    {
        $sortBy = 'name';
        $direction = request('direction') && request('direction') === 'Descending' ? 'DESC' : 'ASC';

        if (request('sort_by')) {

            switch (request('sort_by')) {

                case 'Capacity':
                    $sortBy = 'Capacity';
                    break;
            }
        }

        $wards = Ward::with('admissions')

            ->when(request('query'), function ($query) {

                $query->filter(request('query'));
            })

            ->orderBy($sortBy, $direction)
            ->paginate(request('size', 10))
            ->withQueryString();


        return $wards;
    }
}
