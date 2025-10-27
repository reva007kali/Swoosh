<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwooshWebController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('home', compact('services'));
    }
}
