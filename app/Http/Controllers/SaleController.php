<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

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

        // Validation des données
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'quantity' => 'required|integer|min:1',
        //     'remark' => 'nullable|string',
        //     'product_id' => 'required|exists:products,id' // Assurez-vous que l'ID du produit est valide
        // ]);
        //


        $sale = new Sale();
        $sale->fullName = $request->name;
        $sale->quantity = $request->quantity;
        $sale->remark = $request->remark;
        $product = Product::find($request->product_id);

        if (!$product) {
            return redirect()->back()->withErrors('Produit non trouvé.');
        }

        $totalPrice = $request->quantity * $product->price;
        $sale->total_price = $totalPrice;

        // Trouver la catégorie du produit
        $category = Category::find($product->category_id);

        if (!$category) {
            return redirect()->back()->withErrors('Catégorie non trouvée.');
        }

        // Assigner les valeurs à l'objet sale
        $sale->CategoryId = $category->id;
        $sale->product_id = $request->product_id;
        $sale->save();

        return redirect()->route('sales.index');

        // return "$totalPrice";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sale = Sale::find($id);
        $products = Product::all();
        $category = Category::all();

        return view('sales.print', ["sale" => $sale, "products" => $products, "category" => $category]);
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

    public function print($sale_id)
    {


        // $sale = Sale::with('products')->findOrFail($sale_id);
        /*$products = Product::all();


        $pdf = Pdf::loadView('sales.print', ["sale" => $sale], ["products" => $products]);

        return $pdf->download('recu_vente' .$sale->id . 'pdf');

        $data = [
            'title' => 'Titre du PDF',
            'content' => 'Contenu du PDF à partir de votre vue existante.'
        ];

        $pdf = PDF::loadView('sales.print', $data);

        return $pdf->download('document.pdf');*/


        // Récupérez la vente à partir de votre modèle Sale ou tout autre moyen approprié
        $sale = Sale::findOrFail($sale_id); // Exemple si vous utilisez Eloquent

        // New Add
        $data = [
            'title' => "Reçus",
            'date' => date('m/d/Y')
            // 'sale' => $sale,
        ];

        try {
            $pdf = Pdf::loadView('sales.print', $data);
            return $pdf->download('print.pdf');
        } catch (\Exception $e) {

            return back()->with('error', 'Erreur lors de la génération du PDF');
        }
        // return redirect()->route('sales.index')->with('success', 'PDF généré avec succès!');


        /*$options = new Options();
        $options->set('defaultFont', 'Arial');

        // Instantiate Dompdf with options
        $dompdf = new Dompdf($options);

        // Load HTML content
        $html = view('sales.print')->render(); // Example view file 'pdf/document.blade.php'
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (important for streaming / downloading)
        $dompdf->render();

        // Output generated PDF to Browser (inline view or download)
        return $dompdf->stream('document.pdf');*/
    }

    public function getMonthlySales()
    {
        // Récupérer les ventes agrégées par mois
        // Utiliser strftime pour extraire l'année et le mois
        // $sales = Sale::selectRaw('strftime("%Y-%m", created_at) as month, SUM(total_price) as total')
        $sales = Sale::selectRaw('strftime(quantity) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // $sales = Sale::selectRaw('strftime("%m", created_at) as month, SUM(total_price) as total')
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get()
        //     ->mapWithKeys(function ($item) {
        //         return [$item->month => $item->total];
        // });

        return view('stat', $sales);
    }

    public function getMonthlyCount()
    {
        // Récupérer les ventes agrégées par mois
        // Utiliser strftime pour extraire l'année et le mois
        // $sales = Sale::selectRaw('strftime("%Y-%m", created_at) as month, SUM(total_price) as total')
        $sales = Sale::selectRaw('strftime(quantity) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
        // $sales = Sale::selectRaw('strftime("%m", created_at) as month, SUM(total_price) as total')
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get()
        //     ->mapWithKeys(function ($item) {
        //         return [$item->month => $item->total];
        // });

        return view('stat', $sales);
    }

    public function report(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Sale::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            // return view('sales.see')->with('error', 'Veillez renter une date de début et une date de fin !');
        }
        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])->get();

        $totalSales = $query->count();
        $totalProducts = Product::count();
        $totalRevenue = $query->sum('total_price');
        // $sales = Sale::all();


        return view('sales.bilan', [
            'totalSales' => $totalSales,
            'totalProducts' => $totalProducts,
            'totalRevenue' => $totalRevenue,
            'startDate' => $startDate,
            'endDate' => $endDate,
            "sales" => $sales
        ]);
    }
}
