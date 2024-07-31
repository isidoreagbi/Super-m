<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sales = Sale::all();
        $products = Product::all();

        return view('sales.index', ["sales" => $sales, "products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        $sales = Sale::all();
        
        return view('sales.create', ["products" => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $sale = new Sale();
        $sale->fullName = $request->name;
        $sale->quantity = $request->quantity;
        $sale->remark = ($request->quantity) * 2;
        $sale->product_id = $request->product_id;
        $sale->save();

        return redirect()->route('sales.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sale = Sale::find($id);
        $product = Product::all();
        $category = Category::all();

        return view('sales.print', ["sale" => $sale, "product" => $product, "category" => $category]);
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
        $sale = Sale::find($id);
        $sale->delete();
        return back()->with('success', 'Vente supprimé avec succès !');
    }
}
