<?php

namespace App\Repositories;

use App\Charts\ProductChart;
use App\Charts\SaleChart;
use App\Interfaces\ProductInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;

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
        $chart->dataset("Ordinateurs", "doughnut", $count)->options([
            'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512"],
        ]);

        return $chart;
    }

    // public function chartBySaleProduct()
    // {

    //     $data = Product::select('category_id')
    //         ->selectRaw("'strftime(quantity) as month, SUM(total_price) as total'")
    //         // ->selectRaw("strftime('%m', created_at) as month, COUNT(*) as count")
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();

    //     $json_data = json_decode($data, true);

    //     $names = [];
    //     $total = [];


    //     for ($i=1; $i <= 12; $i++) {
    //         $month = date('F',mktime(0,0,0,$i,1));
    //         $names[] = $month;
    //         foreach ($json_data as $item) {
    //             // $i++;
    //             $total[] = $item['total'];
    //         }
    //     }

    //     $chart = new SaleChart;
    //     $chart->labels($names);
    //     $chart->dataset("Ventes $month", "bar", [12, 4, 25, 1, 7, 7, 85, 21, 4, 52, 52, 22])->options([
    //         'backgroundColor' => ['#046e24', "#dd4c09", "#0b7ad4", "#b20bd4", "#d1163e", "#178897", "#587512", 'red', 'blue', 'yellow', '#ccc', 'black'],
    //     ]);

    //     return $chart;
    // }

    public function chartBySaleProduct()
    {
        // Récupérer les données agrégées par mois
        $data = Sale::selectRaw('strftime("%m", created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Préparer les données pour le graphique
        $names = [];
        $total = [];

        // Remplir les mois et les totaux avec des valeurs par défaut
        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $names[] = $month;
            $total[$i] = 0; // Initialiser avec 0
        }

        // Remplir les totaux des ventes pour chaque mois
        foreach ($data as $item) {
            $month = (int)$item->month; // Convertir le mois en entier
            $total[$month] = $item->total; // Assigner le total du mois
        }

        // Créer le graphique
        $chart = new SaleChart();
        $chart->labels($names);
        $chart->dataset('Ventes $month', 'bar', array_values($total))->options([
            'backgroundColor' => ['#046e24', '#dd4c09', '#0b7ad4', '#b20bd4', '#d1163e', '#178897', '#587512', 'red', 'blue', 'yellow', '#ccc', 'black'],
        ]);

        return $chart;
    }

    public function chartByCountSaleProduct()
    {
        // Récupérer les données agrégées par mois
        $data = Sale::selectRaw('strftime("%m", created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Préparer les données pour le graphique
        $names = [];
        $total = [];

        // Remplir les mois et les totaux avec des valeurs par défaut
        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1));
            $names[] = $month;
            $total[$i] = 0; // Initialiser avec 0
        }

        // Remplir les totaux des ventes pour chaque mois
        foreach ($data as $item) {
            $month = (int)$item->month; // Convertir le mois en entier
            $total[$month] = $item->total; // Assigner le total du mois
        }

        // Créer le graphique
        $chart = new SaleChart();
        $chart->labels($names);
        $chart->dataset('Ventes $month', 'bar', array_values($total))->options([
            'backgroundColor' => ['#046e24', '#dd4c09', '#0b7ad4', '#b20bd4', '#d1163e', '#178897', '#587512', 'red', 'blue', 'yellow', '#ccc', 'black'],
        ]);
        // $chart->dataset('Ventes $month', 'line', array_values($total))->options([
        //     'backgroundColor' => 'transparent',
        //     'borderWidth' => 5 ,
        //     'borderColor' => 'yellow'
        // ]);

        return $chart;
    }

    public function chartBySumProduct()
    {
        // Récupérer les données agrégées par mois
        $data = Sale::selectRaw('product_id as product, COUNT(*) as count')
            ->groupBy('product')
            ->orderBy('count')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            $names[] = Product::find($item['product'])->name;
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Produits", "line", $count)->options([
            'backgroundColor' => 'transparent',
            'borderWidth' => 3,
            'borderColor' => 'yellow'
        ]);

        return $chart;
    }

    /* /// Diagramme pour radar
        public function chartBySumProduct()
    {
        // Récupérer les données agrégées par mois
        $data = Sale::selectRaw('product_id as product, COUNT(*) as count')
            ->groupBy('product')
            ->orderBy('product')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            $names[] = Product::find($item['product'])->name;
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Produits", "radar", $count)->options([
            'backgroundColor' => 'transparent',
            'borderWidth' => 3,
            'borderColor' => 'yellow'
        ]);

        return $chart;
    }
    */

    public function chartBySumCategory()
    {
        // Récupérer les données agrégées par mois
        $data = Sale::selectRaw('CategoryId as Category, COUNT(*) as count')
            ->groupBy('Category')
            ->orderBy('count')
            ->get();

        $json_data = json_decode($data, true);

        $names = [];
        $count = [];

        $i = 0;

        foreach ($json_data as $item) {
            $i++;
            $count[] = $item['count'];
            // $names[] = $item->productCategory;
            // $names[] = Category::find(Product::find($item['productCategory'])->id)->name;
            $names[] = Category::find($item['Category'])->name;
        }

        $chart = new ProductChart;
        $chart->labels($names);
        $chart->dataset("Categories", "line", $count)->options([
            'backgroundColor' => 'transparent',
            'borderWidth' => 3,
            'borderColor' => 'red'
        ]);

        return $chart;
    }
}
