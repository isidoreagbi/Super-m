@extends('layout.base')

@section('css')
    <style>
        canvas {
            width: 100% !important;
            aspect-ratio: 1/1;
            height: 400px !important;
            /* aspect-ratio: 1/1; */
        }
    </style>
@endsection

@section('content')
    {{-- <?php
    // function redirect(){
    //     if (!isset($_COOKIE['clientId'])) {
    //         return route('login');
    //     }
    // }
    ?> --}}
    @include('includes.sidebar')

    <div class="wrap-content">

        @include('includes.appbar')

        <br /><br /><br />

        <div class="d-grid-4">
            <div class="dashboard-card">
                <table width="100%">
                    <tr>
                        <td>
                            <span class="h1">{{ $categories }}</span>
                            <small>Catégories</small>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('categories.index') }}" class="button primary">
                                <i class="fas fa-arrow-right-long"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="dashboard-card">
                <table width="100%">
                    <tr>
                        <td>
                            <span class="h1">{{ $products }}</span>
                            <small>Produits</small>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('categories.index') }}" class="button success">
                                <i class="fas fa-arrow-right-long"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="dashboard-card">
                <table width="100%">
                    <tr>
                        <td>
                            <span class="h1">{{ $sales }}</span>
                            <small>Ventes</small>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('sales.index') }}" class="button error">
                                <i class="fas fa-arrow-right-long"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="dashboard-card">
                <table width="100%">
                    <?php
                    $totalPrice = 0;
                    foreach ($salesPrices as $sale) {
                        $totalPrice = $totalPrice + $sale->total_price;
                    }
                    ?>
                    <tr>
                        <td>
                            <span class="h1">{{ number_format($totalPrice, 0, ' ')}}</span>
                            <small>F CFA</small>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('sales.show.report') }}" class="button warning">
                                <i class="fas fa-arrow-right-long"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{-- <div class="d-grid-6">
            <div>
                {!! $product_chart_by_category->container() !!}
            </div> --}}

        <div class="d-grid-2 dashboard-card">
            <div>
                <h4 style="text-align: center; color:blue">Statistiques de produits par catégorie</h4>
                {!! $product_chart_by_category->container() !!}
            </div>
            <div>
                <h4 style="text-align: center; color:blue">Vente de chaque mois dans l’année</h4>
                {!! $Chart_by_count_sale_product->container() !!}
            </div>
        </div>
        <br /><br />
        <div class="d-grid-1 dashboard-card">
            <div>
                <h4 style="text-align: center; color:blue">chiffres d’affaire global de chaque mois dans l’année</h4>
                {!! $product_chart_by_sale_product->container() !!}
            </div>
        </div>
        <br /><br />
        <div class="d-grid-1 dashboard-card">
            <div>
                <h4 style="text-align: center; color:blue">Produits les plus / moins vendus</h4>
                {!! $chartBySumProduct->container() !!}
            </div>
        </div>
        <br><br>
        <div class="d-grid-1 dashboard-card">
            <div>
                <h4 style="text-align: center; color:blue">Catégories les plus / moins vendus</h4>
                {!! $chartBySumCategory->container() !!}
            </div>
        </div>
        <br><br>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/chart/chart.min.js') }}" charset="utf-8"></script>
    {!! $product_chart_by_category->script() !!}
    {!! $product_chart_by_sale_product->script() !!}
    {!! $Chart_by_count_sale_product->script() !!}
    {!! $chartBySumProduct->script() !!}
    {!! $chartBySumCategory->script() !!}
@endsection
