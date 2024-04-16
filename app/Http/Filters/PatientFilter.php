<?php

namespace App\Http\Filters;

use App\Contracts\Filters\Filterable;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientFilter implements Filterable
{

    public static function get(): LengthAwarePaginator
    {

        $sortBy = ['firstname', 'middlename', 'lastname'];
        $direction = request('direction') && request('direction') === 'Ascending' ? 'ASC' : 'DESC';

        if (request('sort_by')) {

            switch (request('sort_by')) {

                case 'Last Name':
                    $sortBy = ['lastname', 'firstname', 'middlename'];
                    break;

                case 'Creation Date':
                    $sortBy = ['created_at'];
                    break;
            }
        }

        $patients = Patient::query()

            ->when(request('query'), function ($query) {

                $query->filter(request('query'));
            });

        foreach ($sortBy as $sort) {

            $patients = $patients->orderBy($sortBy, $direction);
        }

        $patients = $patients->paginate(request('size', 10))
            ->withQueryString();


        return $patients;
    }
}