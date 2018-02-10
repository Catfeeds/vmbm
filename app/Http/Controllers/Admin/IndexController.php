<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index.index');
    }
}
