<!DOCTYPE html>
<html>

<head>
    <title>Détails de la Vente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>

    <br>

    <div class="container-fluid row">

        <div class="col" style="text-align: right">
            <a href="{{ route('sales.index') }}" class="btn btn-primary">Retour</a>
        </div>
        <div class="col">
            <div class="container card" id="receipt">
                <br>

                <br>
                <div>
                    <h3>Bilan</h3>
                    <form action="{{ route('sales.show.report') }}" method="GET">
                        <div class="form-control">
                            <label for="start_date">Veuillez choisir une Date de début :</label>
                            <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                                class="form-control">
                        </div>

                        <br>

                        <div class="form-control">
                            <label for="end_date">Veuillez choisir une Date de fin :</label>
                            <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                                class="form-control">
                        </div>
                        <br><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </form>

                    <div class="summary">
                        <h2>Résumé</h2>
                        <p><strong>Total des ventes :</strong> <span
                                class="text-primary fs-5"><b>{{ $totalSales }}</b></span></p>
                        <p><strong>Total des produits :</strong> <span
                                class="text-primary fs-5"><b>{{ $totalProducts }}</b></span></p>
                        <p><strong>Revenu total :</strong> <span
                                class="text-primary fs-5"><b>{{ number_format($totalRevenue, 2) }}</b></span>
                            <b>FCFA</b>
                        </p>
                    </div>

                </div>

                <table class="table table-striped">

                    <tr class="table-success">
                        <td>ID</td>
                        <td>Nom du produit</td>
                        <td>Montant</td>
                        <td>Date de Vente</td>
                    </tr>

                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ App\Models\Product::find($sale->product_id)->name }}</td>
                            <td>{{ $sale->total_price }} Fcfa</td>
                            <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col">
            <a href="#!" onclick="printReceipt()" class="btn btn-primary">Imprimer</a>
        </div>
    </div>

    <br><br><br>
</body>

<script>
    function printReceipt() {

        var divToPrint = document.getElementById('receipt');

        var newWin = window.open('', 'Print-Window');

        newWin.document.open();

        newWin.document.write(
            '<html><body onload="window.print()" style="text-align: center;">' +
            divToPrint.innerHTML +
            '</body></html>');

        newWin.document.close();

        setTimeout(function() {
            newWin.close();
        }, 1000);

    }
</script>

</html>
