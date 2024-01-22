<?php

namespace App\Http\Controllers;

use App\Http\Request\Cost\CreateRequest;
use App\Http\Request\Cost\EditRequest;
use App\Models\Cost;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $costs = Cost::query();
            return DataTables::of($costs)
                ->make();
        }
        return view('cost.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $cost = Cost::create([
            'power' => $request->get('power'),
            'cost_per_kwh' => $request->get('cost_per_kwh')
        ]);

        return redirect()->route('costs.index')->with('success', 'Cost created successfully');
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
    public function edit(Cost $cost)
    {
        return view('cost.edit', ['cost' => $cost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Cost $cost)
    {
        $cost->update([
            'power' => $request->get('power'),
            'cost_per_kwh' => $request->get('cost_per_kwh')
        ]);

        return redirect()->route('costs.index')->with('success', 'Cost updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        $cost->delete();

        return redirect()->route('costs.index')->with('success', 'Cost deleted successfully');
    }
}
