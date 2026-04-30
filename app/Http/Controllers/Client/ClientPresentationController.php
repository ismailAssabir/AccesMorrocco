<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientPresentationController extends Controller
{
    /**
     * Display the client presentations page.
     */
    public function index()
    {
        return view('clients.presentations');
    }
}
