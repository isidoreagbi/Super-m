<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\clients;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->cookie('cookie')) {
            // Rediriger vers une autre page si le cookie n'existe pas
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $client = new Clients();

        $username = $request->username;
        $email = $request->email;

        $findUsername = Clients::where('username', $username)->exists();

        if($findUsername){
            return back()->with('error', 'Cet nom d\'utilisateur existe déjà !');
        }

        $client->username = $username;

        $findEmail = Clients::where('email', $email)->exists();

        if($findEmail){
            return back()->with('error', 'Cet email existe déjà !');
        }

        $client->email = $email;

        if($request->ConfirmPassword != $request->input('password')){
            return back()->with('error', 'Les mot de passes sont différents !');
        }

        $client->password = Hash::make($request->password);
        $client->save();

        return redirect()->route('login')->with('succes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if ($request->cookie('cookie')) {
            // Rediriger vers une autre page si le cookie n'existe pas
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $username = $request->username;
        $password = $request->password;


        $client = Clients::where('username', $username)->first();

        if ($client && Hash::check($password, $client->password)) {
            // setcookie('clientId', $client->id, time() + (86400 * 30), "/");
            // session(['client_id' => $client->id]);

            $name = 'cookie';
            $value = $client->id;
            $minutes = (86400 * 30); // Durée de vie en minutes

            // // Créer le cookie
            $cookie = cookie($name, $value, $minutes);

            setcookie('clientId', $client->id, time() + (86400 * 30), "/");


            // Retourner une réponse avec le cookie
            return redirect()->route('home')->with('success', 'connexion reussie')->cookie($cookie);
        } else {
            return back()->with('error', ' Les infos ne sont pas valide');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //

        if (!$request->cookie('cookie')) {
            // Rediriger vers une autre page si le cookie n'existe pas
            return redirect()->route('login');
        }

        $client = Clients::find($id);

        if (!$client) {
        }
        return view('auth.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $clientId)
    {
        //

        $client = Clients::findOrFail($clientId);

        $client->email = $request->email;
        $client->username = $request->username;
        $client->password = Hash::make($request->newPassword);



        $client->save();
        return back()->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //

        if (isset($_COOKIE["clientId"])) {
            setcookie('clientId', "", -1, '/');
        }

        // Définir le nom du cookie
        $name = 'cookie';

        // Créer un cookie avec une durée d'expiration passée pour le supprimer
        $cookie = Cookie::forget($name);

        // Retourner une réponse avec le cookie supprimé


        return redirect()->route('login')->with('status', 'Vous vous êtes deconnectés de votre session')->cookie($cookie);
    }
}
