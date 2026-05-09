<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use App\Http\Requests\StoreRiceRequest;
use App\Http\Requests\UpdateRiceRequest;

class RiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rices = Rice::latest()->paginate(10);
        return view('rice.index', compact('rices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('rice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRiceRequest $request, Rice $rices)
    {
        //
        Rice::create($request->validated());

        return redirect()->route('rice.index')->with('success', 'Rice is added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rice $rices)
    {
        //
        return view('rice.show', compact('rices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rice $rices)
    {
        //
        return view('rice.edit', compact('rices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRiceRequest $request, Rice $rices)
    {
        //
        $rices->update($request->validated());
        return redirect()->route('rice.index')->with('success', 'Rice is updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rice $rices)
    {
        $rices->delete();

        return redirect()->route('rice.index')->with('success', 'Rice deleted!');
    }
}
