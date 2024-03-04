<?php

namespace App\Http\Controllers;

use App\Models\Merchandiser;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    //Login page
    public function login()
    {
        return view("login");
    }
    // CRUD page for merchandiser
    public function merchandiser()
    {
        $merchandisers = Merchandiser::all();
        return view('CRUD', compact('merchandisers'));
    }
    // Showing of attendance based on date
    public function attendance()
    {
        return view("Attendance2");
    }

    public function absent()
    {
        return view('absent');
    }

    public function summary()
    {
        return view('Summary');
    }
}
