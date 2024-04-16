<?php

namespace App\Http\Filters;

use App\Contracts\Filters\Filterable;
use App\Models\Admission;
use Illuminate\Pagination\LengthAwarePaginator;

class AdmissionFilter implements Filterable
{

    public static function get(): LengthAwarePaginator
    {

        $sortBy = 'admitted_at';
        $direction = request('direction') && request('direction') === 'Ascending' ? 'ASC' : 'DESC';

        $admissions = Admission::with('patient')

            ->withWhereHas('patient', function ($query) {

                $query->when(request('patient'), function ($query) {

                    $query->filter(request('patient'));
                });
            })

            ->when(request('ward'), function ($query) {

                $query->where('ward', 'LIKE', '%', request('ward') . '%');
            })

            ->when(request('status') && request('status') !== 'All', function ($query) {

                if (request('status') === 'Admitted') {

                    $query->whereNull('discharged_at');
                } else {

                    $query->whereNotNull('discharged_at');
                }
            })

            ->orderBy($sortBy, $direction)
            ->paginate(request('size', 10))
            ->withQueryString();

        return $admissions;
    }

}