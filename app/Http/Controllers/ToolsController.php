<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function scales()
    {
        return view('admin.tools.scales.index');
    }
}
