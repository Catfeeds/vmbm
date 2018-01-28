<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


class TestController extends Controller
{
    public function index(Request $request)
    {
    	$option = [];
    	foreach($option as $key => $val) {
    		dd($key, $val);
    	}
    	return view('admin.test.index');
    }
}
