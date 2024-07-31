<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;

class MainController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    public function home() {

        $categories = count($this->categoryInterface->index());
        $products = count($this->productInterface->index());


        return view('welcome', [
            "categories" => $categories,
            "products" => $products,
            "product_chart_by_category" => $this->productInterface->chartByCategory()
        ]);
    }
}
