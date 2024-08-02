@extends('layout.app')

@section('title')
    <strong class="text-white">Connexion</strong>
@endsection
@section('content')

    <head>
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    </head>

    <div class="container-fluid row">
        <div class="col"></div>
        <div class="col">
            @if ($message = Session::get('error'))
                <div class="alert alert-success" style="color: red;">
                    {{ $message }}
                </div>
            @endif
        </div>
        <div class="col"></div>
    </div>

    <div class="clear-loading spinner">
        <span></span>
    </div>
    <div class="w3ls-login box box--big">
        <!-- form starts here -->
        <form action="{{ route('login.processing') }}" method="POST">
            @csrf

            <div class="agile-field-txt">
                <label><i class="fa fa-user" aria-hidden="true"></i> Nom d'utilisateur </label>
                <input type="text" name="username" placeholder="Votre nom d'utilisateur" required="" />
            </div>

            <div class="agile-field-txt">

                <div class="agile-field-txt">
                    <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Mot de passe </label>
                    <input type="password" name="password" placeholder="Votre mot de passe" required="" id="myInput" />

                    <div class="agile_label">
                        <input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
                        <label class="check" for="check3">Voir le mot de passe</label>
                    </div>
                    <div class="agile-right">
                        <a href=" {{ route('user.register') }} ">S'inscrire !</a>
                    </div>
                </div>
                <!-- script for show password -->
                <script>
                    function myFunction() {
                        var x = document.getElementById("myInput");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                    }
                </script>
                <br><br><br>
                <!-- //end script -->
                <div class="text-center">
                    <input type="submit" value="LOGIN">
                </div>
        </form>
    </div>
@endsection
