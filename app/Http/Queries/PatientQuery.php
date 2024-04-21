<?php

namespace App\Http\Queries;

use App\Contracts\Queries\Executable;
use App\Models\Patient;
use Illuminate\Support\Collection;

class PatientQuery implements Executable
{

    public static function execute($primary = null, $context = null): Collection
    {
        $patients = collect();

        if ($primary || $context) {

            $patients = Patient::withCount(['admissions' => function ($query) {

                $query->admitted();
            }])


                ->when($primary && !$context, function ($query) use ($primary) {

                    $query->where('id', $primary);
                })

                ->when($context && !$primary, function ($query) use ($context) {
                    $query->filter($context);
                })

                ->orderBy('firstname', 'ASC')
                ->orderBy('middlename', 'ASC')
                ->orderBy('lastname', 'ASC')
                ->orderBy('suffix', 'ASC')
                ->limit(5)
                ->get();
        }

        return ($patients->filter(function ($patient) {
            return $patient->admissions_count <= 0;
        }));
    }
}
