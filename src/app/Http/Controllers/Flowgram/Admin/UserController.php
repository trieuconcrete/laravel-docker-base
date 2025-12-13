<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($planId = $request->get('plan')) {
            $query->whereHas('subscriptions', function ($q) use ($planId) {
                $q->where('plan_id', $planId)->latest();
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'none') {
                $query->doesntHave('subscriptions');
            } else {
                $query->whereHas('subscriptions', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            }
        }

        $users = $query->latest()->paginate(20)->withQueryString();
        $plans = Plan::all();

        return view('flowgram.admin.users.index', compact('users', 'plans'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('flowgram.admin.users.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'subscription_status' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        if (!empty($validated['plan_id'])) {
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $validated['plan_id'],
                'status' => $validated['subscription_status'] ?? 'active',
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', '会員を追加しました');
    }

    public function edit(User $user)
    {
        $plans = Plan::all();
        return view('flowgram.admin.users.edit', compact('user', 'plans'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'postal_code' => $validated['postal_code'],
            'address' => $validated['address'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.users.edit', $user)
            ->with('success', '会員情報を更新しました');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', '会員を削除しました');
    }
}

