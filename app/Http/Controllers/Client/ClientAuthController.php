<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('client')->check()) {
            return redirect()->route('clients.dashboard');
        }
        return view('clients.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();

        if ($client && Hash::check($request->password, $client->password)) {
            Auth::guard('client')->login($client, $request->boolean('remember'));
            $request->session()->regenerate();
            
            return redirect()->route('clients.dashboard')
                ->with('success', 'Bienvenue ' . $client->firstName . ' ' . $client->lastName);
        }

        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        $dossiers = $client->dossiers()->latest()->paginate(10);
        
        return view('clients.dashboard', compact('client', 'dossiers'));
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('clients.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}