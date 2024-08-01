@extends('layout.app')

@section('content')

<div class="wrap-content">
    <div class="container">

        <div style="text-align: right">
            <div></div>
            <div style="margin: 60px">
                <a href="{{ route('logout') }}" style="color: red">Se déconnecter</a>
            </div>
        </div>

        <h1>Modifier le Profil</h1>

        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
        @endif

        <div class="w3ls-login box box--big">

            <form action="{{ route('profiles.update', $client->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="agile-field-txt">
                    <label><i class="fa fa-user" aria-hidden="true"></i> Email </label>
                    <input type="text" name="email" placeholder="Enter Email" value="{{ $client->email }}" required />
                </div>

                <div class="agile-field-txt">
                    <label><i class="fa fa-user" aria-hidden="true"></i> Nom d'utilisateur </label>
                    <input type="text" name="username" placeholder="Enter Username" value="{{ $client->username }}" required />
                </div>

                <div class="agile-field-txt">
                    <label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Nouveau mot de passe</label>
                    <input type="password" name="newPassword" placeholder="Enter Password" id="myInput" />
                </div>



                <div class="agile_label">
                    <input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
                    <label class="check" for="check3">Show password</label>
                </div>


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