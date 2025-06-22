<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home'); // Pastikan file view ini sudah ada
    }
}
