<?php

namespace App\Http\Filters;

use App\Contracts\Filters\Filterable;
use App\Models\Admission;
use Illuminate\Pagination\LengthAwarePaginator;

class AdmissionFilter implements Filterable
{

    public static function get(): LengthAwarePaginator
    {
        $direction = request('direction') && request('direction') === 'Latest' ? 'ASC' : 'DESC';

        $admissions = Admission::with('patient', 'ward')

            ->withWhereHas('patient', function ($query) {

                $query->when(request('patient'), function ($query) {

                    $query->filter(request('patient'));
                });
            })

            ->withWhereHas('ward', function ($query) {

                $query->when(request('ward'), function ($query) {

                    $query->filter(request('ward'));
                });
            })

            ->when(request('status') && request('status') !== 'All', function ($query) {

                if (request('status') === 'Admitted') {

                    $query->whereNull('discharged_at');
                } else {

                    $query->whereNotNull('discharged_at');
                }
            })

            ->orderBy('admitted_at', $direction)
            ->paginate(request('size', 10))
            ->withQueryString();

        return $admissions;
    }
}
