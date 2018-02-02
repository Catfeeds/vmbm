<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class TestController extends Controller
{
    public function index(Request $request)
    {
        dd(dict()->get('device', 'status'));
    }
}
