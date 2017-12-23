<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $tests = Test::paginate(25);
        return view('welcome', compact('tests'));
    }
}
