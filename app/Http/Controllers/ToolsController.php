<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    function index() {
        return view('admin.scales.index');
    }
    public function create()
    {
        return view('admin.scales.create');
    }
}
