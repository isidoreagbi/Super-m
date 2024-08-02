@extends('layout.base')

@section('content')
    @include('includes.sidebar')

    <div class="wrap-content">
        @include('includes.appbar')

        <form action="{{ route('sales.store') }}" class="category-form" method="POST">
            @csrf

            <br /><br /><br /><br />
            <h1>Créer une nouvelle vente</h1>

            <p>Remplir les informations de la vente que vous voulez créer.</p><br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                </ul>
            @endif

            @if ($message = Session::get('error'))
                <ul class="alert alert-danger">
                    <li>{{ $message }}</li>
                </ul>
            @endif

            @if ($message = Session::get('success'))
                <ul class="alert alert-success">
                    <li>{{ $message }}</li>
                </ul>
            @endif

            <label for="category"><b>Le produit en vente</b></label>
            <select name="product_id" id="category" required>
                <option value="">Sélectionner un produit</option>
                @forelse ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @empty
                    <option value="">Pas de produit !</option>
                @endforelse
            </select>
            <br />

            <label for="name"><b>Nom complet de l'acheteur</b></label>
            <input type="text" placeholder="Nom de l'acheteur ..." id="name" minlength="3" maxlength="128"
                name="name" required />
            <br />

            <table width="100%">
                <tr>
                    {{-- <td>
                        <label for="price"><b>Nombre du produit vendu</b></label>
                        <input type="number" min="0" value="100" max="1000000" placeholder="Nombre de produit ..."
                            id="price" name="price" required />
                    </td> --}}
                    <td>
                        <label for="quantity"><b>Quantité vendu</b></label>
                        <input type="number" min="1" value="1" max="1000000" placeholder="quantité ..."
                            id="quantity" name="quantity" required />
                    </td>
                </tr>
            </table><br />

            {{-- <label for="remark"><b></b> [Facultatif]</label>
            <textarea name="remark" id="remark" rows="3"
                placeholder=""></textarea><br /><br /> --}}

            <label for="summernote"><b>Remarque</b> [Facultatif]</label><br /><br />
            <textarea name="remark" id="summernote" rows="8" placeholder="Saisir une remarque sur la vente ..."></textarea><br />

            <button type="submit" class="button w-100 primary">Soumettre</button>
        </form><br /><br /><br /><br />

    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: "Saisir une remarque ...",
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'help']]
                ]
            });
        });
    </script>
@endsection
