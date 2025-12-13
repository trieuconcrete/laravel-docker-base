<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('flowgram.admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('flowgram.admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'item_name' => ['nullable', 'string', 'max:255'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        $order->update($validated);

        if ($validated['status'] === 'completed' && !$order->completed_at) {
            $order->update(['completed_at' => now()]);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', '申込情報を更新しました');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', '申込を削除しました');
    }
}

