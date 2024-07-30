<?php

namespace App\Repositories;

use App\Charts\ProductChart;
use App\Charts\SaleChart;
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

    public function chartBySaleProduct()
    {

        $data = Product::select('category_id')
            ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        // $data = Product::selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
        //             ->whereYear('created_at',date('Y'))
        //             ->groupBy('month')
        //             ->orderBy('month')
        //             ->get();

        // $labels = [];
        // $data2 = [];
        // $colors = ['blue', 'red', 'green', 'black', 'yellow'];
        // $int = [5, 10, 2, 5, 2];

        // for ($i=1; $i < 12; $i++) { 
        //     $month = date('F',mktime(0,0,0,$i,1));
        //     $count = 0;

        //     foreach ($data as $datas) {
        //         if ($datas->month == $i) {
        //             $count = $datas->count;
        //             break;
        //         }
        //     }

        //     array_push($labels,$month);
        //     array_push($data2,$count);
        // }

        // $datasets = [
        //     [
        //         'label' => 'Users',
        //         'data' => $data,
        //         'backgroundColor' => $colors
        //     ]
        //     ];

            // $chart = new SaleChart;
            // $chart->labels($month);
            // $chart->dataset("Ordinateurs", "bar", $int)->options([
            //     'backgroundColor' => $colors,
            // ]);

            // return $chart;


        //------------------------------------------------------------------

        // for ($i=1; $i < 12; $i++) { 
        //     $month = date('F',mktime(0,0,0,$i,1));
        //     $count = 0;

        //     foreach ($data as $datas) {
        //         if ($datas->month == $i) {
        //             $count = $datas->count;
        //             break;
        //         }
        //     }

        //     array_push($labels,$month);
        //     array_push($data2,$count);
        // }
        // $i = 0;

        for ($i=1; $i < 12; $i++) {
            $month = date('F',mktime(0,0,0,$i,1));
            $names[] = $month;
            foreach ($json_data as $item) {
                // $i++;
                $count[] = $item['count'];
            }
        }
        

        $chart = new SaleChart;
        $chart->labels($names);
        $chart->dataset("Ventes $month", "bar", [12, 4, 25, 1, 7, 7, 85, 21, 4, 52, 52, 22])->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart;
    }
}