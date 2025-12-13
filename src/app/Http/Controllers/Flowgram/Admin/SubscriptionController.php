<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'status' => ['required', 'string'],
        ]);

        Subscription::create([
            'user_id' => $validated['user_id'],
            'plan_id' => $validated['plan_id'],
            'status' => $validated['status'],
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        return back()->with('success', 'サブスクリプションを追加しました');
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'status' => ['required', 'string'],
        ]);

        $subscription->update($validated);

        if ($validated['status'] === 'cancelled' && !$subscription->cancelled_at) {
            $subscription->update(['cancelled_at' => now()]);
        }

        return back()->with('success', 'サブスクリプションを更新しました');
    }
}

