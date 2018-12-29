<?php

namespace App\Http\Controllers\TCCX;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GateLandController extends Controller
{
    public function index()
    {
        return view('tccx.gate_land.index');
    }
}
