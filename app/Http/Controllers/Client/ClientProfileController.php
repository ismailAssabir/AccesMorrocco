<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    /**
     * Display the client profile page.
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        return view('clients.profile', compact('client'));
    }
}
