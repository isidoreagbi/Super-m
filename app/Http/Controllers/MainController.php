<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Models\Sale;
use Illuminate\Http\Request;


class MainController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    public function home(Request $request) {

        if (!$request->cookie('cookie')) {
            // Rediriger vers une autre page si le cookie n'existe pas
            return redirect()->route('login');
        }

        $categories = count($this->categoryInterface->index());
        $products = count($this->productInterface->index());
        $sales = count(Sale::all());
        $salesPrices = Sale::all();

        
        return view('welcome', [
            "categories" => $categories,
            "products" => $products,
            "sales" => $sales,
            "salesPrices" => $salesPrices,
            "product_chart_by_category" => $this->productInterface->chartByCategory(),
            "product_chart_by_sale_product" => $this->productInterface->chartBySaleProduct(),
            "Chart_by_count_sale_product" => $this->productInterface->chartByCountSaleProduct(),
            "chartBySumProduct" => $this->productInterface->chartBySumProduct(),
            "chartBySumCategory" => $this->productInterface->chartBySumCategory()
        ]);
    }
    // public function home() {

    //     $categories = count($this->categoryInterface->index());
    //     $products = count($this->productInterface->index());


    // }
}
