<?php

namespace App\Http\Controllers\Seller; // <--- Namespace Wajib Benar


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil file dari folder: resources/views/seller/dashboard.blade.php
        return view('seller.sellerdashboard'); 
    }
}