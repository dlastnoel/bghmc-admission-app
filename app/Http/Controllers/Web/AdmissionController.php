<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Filters\AdmissionFilter;
use App\Http\Requests\StoreAdmissionRequest;
use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admissions = fn() => AdmissionResource::collection(AdmissionFilter::get());

        $filters = fn() => $request->only('patient', 'ward', 'status', 'sort_by', 'direction', 'size');

        return Inertia::render('App/Admissions/Index', [
            'admissions' => $admissions,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdmissionRequest $request)
    {
        $admission = Admission::create($request->validated());

        return redirect()->route('admissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}