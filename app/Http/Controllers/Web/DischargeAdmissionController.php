<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DischargeAdmissionRequest;
use App\Models\Admission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class DischargeAdmissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(DischargeAdmissionRequest $request)
    {
        Admission::whereNull('discharged_at')
            ->where('id', $request->validated('id'))
            ->update([
                'discharged_at' => Carbon::now()
            ]);

        return Redirect::back();
    }
}
