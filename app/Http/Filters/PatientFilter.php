<?php

namespace App\Http\Filters;

use App\Contracts\Filters\Filterable;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientFilter implements Filterable
{

    public static function get(): LengthAwarePaginator
    {

        // $sortBy = ['firstname', 'middlename', 'lastname'];
        $sortBy = ['created_at'];
        $direction = request('direction') && request('direction') === 'Ascending' ? 'ASC' : 'DESC';

        if (request('sort_by')) {

            switch (request('sort_by')) {

                case 'Name':
                    $sortBy = ['lastname', 'firstname', 'middlename'];
                    break;

                case 'Date Created':
                    $sortBy = ['created_at'];
                    break;
            }
        }

        $patients = Patient::query()

            ->when(request('query'), function ($query) {

                $query->filter(request('query'));
            });

        foreach ($sortBy as $sort) {

            $patients = $patients->orderBy($sort, $direction);
        }

        $patients = $patients->paginate(request('size', 10))
            ->withQueryString();


        return $patients;
    }
}
