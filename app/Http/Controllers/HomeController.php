<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $produks = Produk::with('toko')->where('status', 'aktif')->latest()->get();
        
        return view('welcome', compact('categories', 'produks'));
    }
}
