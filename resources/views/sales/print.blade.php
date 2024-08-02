@extends('layout.base')


@section('content')
    @include('includes.sidebar')

    @include('includes.appbar')
    <div class="wrap-content print-body">


        <br /><br /><br />

        <div class="d-grid-4">
        </div>

        <div class="d-grid-6">
        </div>

        <div class="container print-row ">
            <div class="col"></div>
            <div class="alert alert-success reciev" id="receipt">

                {{-- @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @endif --}}

                <div style="background-color: #D8F7D3; border-raduis: 30px; padding: 10px;">
                    
                <h2>Reçus No: {{ $sale->id }}</h2>
                <h2 class="receipt-title">Super m Master</h2>
                <p>Lomé, Togo</p>
                <p>Créé le {{ $sale->created_at }}</p>
                <p>Tel: (+228) 98 58 93 02</p>

                <p>
                    Client : {{ $sale->fullName }}
                </p>

                {{-- <table>
                    <tr>
                        <td>Mode Règlement</td>
                        <td class="table-spacer"></td>
                        <td>Espèce</td>
                    </tr>

                    <tr>
                        <td>Prix du unitaire produit</td>
                        <td class="table-spacer"></td>
                        <td>{{ App\Models\Product::find($sale->product_id)->price }} FCFA</td>

                    </tr>
                    <tr>
                        <td>Quantité du produit</td>
                        <td class="table-spacer"></td>
                        <td>{{ $sale->quantity }}</td>
                    </tr>
                    <tr>
                        <td>Prix totale</td>
                        <td class="table-spacer"></td>
                        <?php
                        // $total = App\Models\Product::find($sale->product_id)->price * $sale->quantity;
                        ?>
                        <td>{{ $total }} FCFA</td>
                    </tr>
                </table> --}}
                
                <div class="table-grid">
                    <?php
                    $total = App\Models\Product::find($sale->product_id)->price * $sale->quantity;
                    ?>
                    <div>Nom du produit:  {{ App\Models\Product::find($sale->product_id)->name }}</div>
                    <br>
                    <div>Mode Règlement:  Espèce</div>
                    <br>
                    <div>Prix unitaire du produit: {{ App\Models\Product::find($sale->product_id)->price }} FCFA</div>
                    <br>
                    <div>Quantité du produit: {{ $sale->quantity }}</div>
                    <br>
                    <div>Prix totale: {{ $total }} FCFA</div>
                </div>
                <h4>Merci pour votre achat !</h4>
                </div>

            </div>
            <div class="col" style="margin-top: 20px">

                <?php
                $product_id = App\Models\Product::find($sale->product_id);
                // 'product_id' => $product_id]     ['sale_id' => $sale->id]
                ?>

                <a href="#!" onclick="printReceipt()" class="download-btn">
                    <i class="fas fa-arrow-down"></i>
                </a>

            </div>
        </div>


    </div>
@endsection

@section('js')
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
@endsection