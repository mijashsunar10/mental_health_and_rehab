<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function showConfirmation(Order $order)
{
    // Verify the order belongs to the authenticated user
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    return view('orders.confirmation', [
        'order' => $order->load('package'),
        'selectedOption' => $order->package->options[$order->option_index] ?? null
    ]);
}
}
