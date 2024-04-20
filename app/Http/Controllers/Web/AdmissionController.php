<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Filters\AdmissionFilter;
use App\Http\Queries\PatientQuery;
use App\Http\Requests\StoreAdmissionRequest;
use App\Http\Resources\AdmissionResource;
use App\Http\Resources\PatientResource;
use App\Models\Admission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admissions = fn () => AdmissionResource::collection(AdmissionFilter::get());
        $admissionsToday = fn () => Admission::whereDate('admitted_at', Carbon::today())
            ->whereNull('discharged_at')->count();

        $filters = fn () => $request->only('patient', 'ward', 'status', 'sort_by', 'direction', 'size');

        return Inertia::render('App/Admissions/Index', [
            'admissions' => $admissions,
            'admissions_today' => $admissionsToday,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = fn () => PatientResource::collection(PatientQuery::execute(request('patient_id'), request('query')));

        return Inertia::render('App/Admissions/Create', [
            'patients' => $patients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdmissionRequest $request)
    {
        Admission::create([
            ...$request->validated(),
            'admitted_at' => Carbon::now()
        ]);

        return redirect()->route('admissions.index');
    }
}
