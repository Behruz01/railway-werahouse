<?php

namespace App\Http\Controllers;

use App\Models\Train;
use App\Models\Wagon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WagonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $wagons = Wagon::with(['vans', 'orders'])->get();
        return view('wagons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vans = Van::all();
        return view('wagons.create', compact('vans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'van_id' => 'required|exists:vans,id',
            'wagon_number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Wagon::create($request->all());

        return redirect()->route('wagons.index')
            ->with('success', 'Wagon created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wagon $wagon)
    {
        $wagon->load(['vans', 'orders.user']);
        return view('wagons.show', compact('wagon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wagon $wagon)
    {
        $vans = Van::all();
        return view('wagons.edit', compact('wagon', 'vans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wagon $wagon)
    {
        $validator = Validator::make($request->all(), [
            'van_id' => 'required|exists:vans,id',
            'wagon_number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $wagon->update($request->all());

        return redirect()->route('wagons.index')
            ->with('success', 'Wagon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wagon $wagon)
    {
        $wagon->delete();

        return redirect()->route('wagons.index')
            ->with('success', 'Wagon deleted successfully.');
    }
}
