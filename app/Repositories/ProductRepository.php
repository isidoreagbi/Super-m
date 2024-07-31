<?php

namespace App\Repositories;

use App\Charts\ProductChart;
use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\Models\Product;

class ProductRepository implements ProductInterface
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $id)
    {
        return Product::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

    /*public function chartByCategory()
    {

        $data = Product::select('name')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category_id')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $names[] = $item['name'];
            $count[] = $item['count'];
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Ordinateurs", "pie", $count)->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart;
    }*/
    
    public function chartByCategory()
    {

        $data = Product::select('category_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category_id')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            $names[] = Category::find($item['category_id'])->name;
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Ordinateurs", "pie", $count)->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart;
    }
}