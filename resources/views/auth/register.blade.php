@extends('layout.app')

@section('title')
    <strong class="text-white">Inscription</strong>
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
    <br>
    <div class="clear-loading spinner">
        <span></span>
    </div>
    <div class="w3ls-login box box--big">

        <form action="{{ route('register.processing') }}" method="POST">
            @csrf

            <div class="agile-field-txt">
                <label><i class="fa fa-user" aria-hidden="true"></i> Nom d'utilisateur </label>
                <input type="text" name="username" placeholder="Entez un nom d'utilisateur" required="" />
            </div>

            <div class="agile-field-txt">

                <label><i class="fa fa-envelope" aria-hidden="true"></i>Email</label>
                <input type="text" name="email" placeholder="Entrez votre email" required="" />
            </div>

            <div class="agile-field-txt">
                <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Mot de passe </label>
                <input type="password" name="password" placeholder="Entrez un mot de passe" required="" id="myInput" />
                <br><br>
                <div class="agile-field-txt">
                    <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirmation de mot de passe </label>
                    <input type="password" name="ConfirmPassword" placeholder="Confirmez votre mot de passe" required=""
                        id="myInput" />

                    <div class="agile_label">
                        <input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
                        <label class="check" for="check3">Show password</label>
                    </div>
                    <div class="agile-right">
                        <a href=" {{ route('login') }} ">Se connecter !</a>
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
                <!-- //end script -->

                <br><br>
                <div class="text-center">
                    <input type="submit" value="Register">
                </div>
        </form>
    </div>
@endsection
