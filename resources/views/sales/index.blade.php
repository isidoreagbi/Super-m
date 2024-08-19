@extends('layout.base')

@section('content')
    @include('includes.sidebar')

    <div class="wrap-content">
        @include('includes.appbar')

        <br /><br /><br />

        <div>
            <table width="100%">
                <tr>
                    <td>
                        <h2>Liste des Ventes</h2>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('sales.show.report') }}" class="button primary">
                            Voir le bilan
                        </a>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('sales.create') }}" class="button primary">
                            Créer
                        </a>
                    </td>
                </tr>
            </table><br />

            @if ($message = Session::get('success'))
                <ul class="alert alert-success">
                    <li>{{ $message }}</li>
                </ul>
            @endif

            <div class="border datatable-cover">
                <table id="datatable" class="stripe">
                    <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Prix</th>
                            <th>Nom de l'acheteur</th>

                            <th>Remarque</th>
                            <th>Quantité commandé</th>
                            <th width="100" class="text-center">
                                Opérations
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>
                                    {{-- {{ $sale->name }} --}}
                                    @foreach ($products as $product)
                                        {{-- value="{{ $product->id }}" {{ $product->category_id == $product->id ? 'selected' : '' }} --}}
                                        {{-- {{ $product->name }} --}}
                                    @endforeach

                                    {{ App\Models\Product::find($sale->product_id)->name }}

                                    {{-- {{ $product->name }} --}}
                                </td>



                                <td>
                                    {{ number_format(App\Models\Product::find($sale->product_id)->price, 0, ' ') }} F CFA
                                </td>
                                <td>
                                    {{ $sale->fullName }}
                                </td>
                                <td>
                                    {!! $sale->remark !!}
                                </td>
                                <td>

                                    {{ $sale->quantity }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('sales.print', $sale->id) }}" class="icon-button primary">
                                        <i class="fas fas fa-print"></i>
                                    </a>
                                    &nbsp;
                                    <form class="d-inline" action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer cette vente {{ $product->name }} ? Cette action sera irréversible !')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button error">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
