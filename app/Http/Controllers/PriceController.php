<?php

namespace App\Http\Controllers;

use App\Models\UnitPrice;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = UnitPrice::all();
        return Inertia::render('Prices/Index',[
            'prices' => $prices
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Prices/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => [
                'required',
                'integer'
            ],
            'month' => 'required',
            'ago' => 'required',
            'pms' => 'required'
        ]);
        try{
            UnitPrice::create($request->all());
        }catch(Exception $e){
                return response()->json([
                    'message'  => $e->getMessage()
                ]);
        }
       

        return to_route('prices.index');
        // dd($request->all());
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
          $price = UnitPrice::find($id);
          return Inertia::render('Prices/Edit',[
            'price' => $price
          ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $price = UnitPrice::findOrFail($id);
        $price->update($request->only(['month','year','pms','go']));


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
