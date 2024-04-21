<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Filters\WardFilter;
use App\Http\Requests\StoreWardRequest;
use App\Http\Requests\UpdateWardFormRequest;
use App\Http\Resources\WardResource;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wards = fn () => WardResource::collection(WardFilter::get());

        $filters = fn () => $request->only('query, sort_by, direction, size');

        return Inertia::render('App/Wards/Index', [
            'wards' => $wards,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('App/Wards/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWardRequest $request)
    {
        Ward::create($request->validated());

        return Redirect::route('wards.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ward $ward)
    {
        $ward = new WardResource($ward->load('admissions'));

        return Inertia::render('App/Wards/Show', [
            'ward' => $ward
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ward $ward)
    {
        $ward = new WardResource($ward->load('admissions'));

        return Inertia::render('App/Wards/Edit', [
            'ward' => $ward
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWardFormRequest $request, Ward $ward)
    {
        $ward->update($request->validated());

        return Redirect::route('wards.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
