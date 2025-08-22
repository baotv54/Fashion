<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Contact;

use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function index()
{
    // Lọc orders chỉ lấy status = 'ordered'
    $orders = Order::where('status', 'ordered')->get();

    $products = Product::all();

    // Lọc contacts chỉ lấy status = 'processing'
    $contacts = Contact::where('status','processing')->get();

    return view('layouts.partials.navbar', compact('orders','products','contacts'));
}

}
