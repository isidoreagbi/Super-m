<?php

namespace App\Http\Controllers;

use App\Classes\ResponseClass;
use App\Http\Requests\Products\CreateProductRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $data = $this->productInterface->index();

        return view('products.index', [
            'page' => 'products',
            'products' => $data,
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryInterface->index();

        return view("products.create", [
            "page" => "products.create",
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        // $myRequest = new Request;
        
        if ($request->hasFile("image")) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'db/products/' . $_FILES['image']['name']);
            $image = $_FILES['image']['name'];
        } else {
            $image = '';
        }

        $data = [
            "name" => $request->name,
            "category_id" => $request->category_id,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "short_description" => $request->short_description,
            "long_description" => $request->long_description,
            "image" => $image,
        ];

        DB::beginTransaction();

        try {
            $this->productInterface->store($data);
            DB::commit();

            return ResponseClass::success();
        } catch (\Throwable $th) {
            return ResponseClass::rollback();
        }
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
        $product = Product::find($id);
        $categories = Category::all();

        return view('products.edit', ["product" => $product, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->short_description = $request->short_description;

        if ($request->hasFile("image")) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'db/products/' . $_FILES['image']['name']);
            $product->image = $_FILES['image']['name'];
        }
        // $product->image = $request->file;
        $product->save();

        // return view('products.index')->with('success', 'Le produit a été modifié avec succès !');
        // return redirect()->route('index');
        return back()->with("success", "Votre produit a été modifié avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        
        return back()->with("success", "Votre produit a été supprimé avec succès !");
    }
}
