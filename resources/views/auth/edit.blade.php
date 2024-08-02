@extends('layout.app')

@section('content')

<div class="wrap-content">

    <head>
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    </head>
    <div class="">

        <div class="container-fluid row">
            <div class="col">
                <a href="{{ route("home") }}" class="btn btn-primary mt-5 ms-5">Retour</a>
            </div>
            <div class="col">        
                <h1 class="text-danger">Modifier le Profil</h1>
            </div>
            <div class="col">
                <div style="text-align: right">
                    <div class="me-5 mt-5">
                        <a href="{{ route('logout') }}" class="btn btn-danger">Se déconnecter</a>
                    </div>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
        <div class="container-fluid row">
            <div class="col"></div>
            <div class="col">
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            </div>
            <div class="col"></div>
        </div>
        @endif

        <div class="w3ls-login box box--big">

            <form action="{{ route('profiles.update', $client->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="agile-field-txt">
                    <label><i class="fa fa-user" aria-hidden="true"></i> Email </label>
                    <input type="text" name="email" placeholder="Votre email" value="{{ $client->email }}" required />
                </div>

                <div class="agile-field-txt">
                    <label><i class="fa fa-user" aria-hidden="true"></i> Nom d'utilisateur </label>
                    <input type="text" name="username" placeholder="Votre Nom d'utilisateur" value="{{ $client->username }}" required />
                </div>

                <div class="agile-field-txt">
                    <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Nouveau mot de passe</label>
                    <input type="password" name="newPassword" placeholder="Votre Mot de passe" id="myInput" />
                </div>


{{-- 
                <div class="agile_label">
                    <input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
                    <label class="check" for="check3">Show password</label>
                </div> --}}


                <script>
                    function myFunction() {
                        var x = document.getElementById("myInput");
                        var y = document.getElementById("myInputConfirm");
                        if (x.type === "password" && y.type === "password") {
                            x.type = "text";
                            y.type = "text";
                        } else {
                            x.type = "password";
                            y.type = "password";
                        }
                    }
                </script>


                <input type="submit" value="Mettre à jour">
            </form>





        </div>
    </div>


    @endsection