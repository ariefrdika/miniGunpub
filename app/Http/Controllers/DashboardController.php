<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Barang;

class DashboardController extends Controller
{
    public function home()
    {
        $barangs = Barang::all();

        return view('dataview_home', compact('barangs'));
    }

    public function index()
    {
        $barangs = Barang::all();

        return view('dashboards.dataview', compact('barangs'));
    }
}
