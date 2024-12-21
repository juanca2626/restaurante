<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $weeksToAdd = (int)($request->add_weeks ?? 1);
        $monday = now()->addWeeks($weeksToAdd)->startOfWeek();
        $friday = $monday->copy()->next(5)->format('Y-m-d');
        $orders = Order::whereBetween('delivery_date', [$monday->format('Y-m-d'), $friday])
            ->orderBy('created_at', 'desc')
            ->with(['customer', 'dish'])
            ->get();
        return view('vendor.backpack.ui.dashboard', compact('orders', 'monday'));
    }

    public function ordersByClient(Request $request)
    {
        $weeksToAdd = (int)($request->add_weeks ?? 1);
        $monday = now()->addWeeks($weeksToAdd)->startOfWeek();
        $friday = $monday->copy()->next(5)->format('Y-m-d');
        $orders = Order::whereBetween('delivery_date', [$monday->format('Y-m-d'), $friday])
            ->orderBy('created_at', 'desc')
            ->with(['customer', 'dish'])
            ->get();
        return view('vendor.backpack.ui.orders-by-client', compact('orders', 'monday'));
    }
}
