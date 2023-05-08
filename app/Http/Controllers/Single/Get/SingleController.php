<?php

namespace App\Http\Controllers\Single\Get;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function about()
    {
        return view("about");
    }

    public function contacts()
    {
        return view("contacts");
    }

    public function repair()
    {
        return view("repair");
    }

    public function tradein()
    {
        return view("tradein");
    }
}
