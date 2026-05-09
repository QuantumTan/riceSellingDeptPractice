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
        $rices = Rice::latest()->paginate(4);
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
    public function store(StoreRiceRequest $request)
    {
        //
        Rice::create($request->validated());

        return redirect()->route('rices.index')->with('success', 'Rice is added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rice $rice)
    {
        //
        return view('rice.show', compact('rice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rice $rice)
    {
        //
        return view('rice.edit', compact('rice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRiceRequest $request, Rice $rice)
    {
        //
        $rice->update($request->validated());
        return redirect()->route('rices.index')->with('success', $rice->rice_name . '  is updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rice $rice)
    {
        $rice->delete();

        return redirect()->route('rices.index')->with('success', $rice->rice_name .  '  deleted!');
    }
}
