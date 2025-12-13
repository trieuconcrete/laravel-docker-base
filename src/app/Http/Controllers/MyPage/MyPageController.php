<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MyPageController extends Controller
{
    /**
     * Get common data for mypage views
     */
    private function getCommonData()
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()->latest()->first();
        $plan = $subscription?->plan;
        
        $statusClass = match($subscription?->status ?? 'none') {
            'pending' => 'pending', 'confirmed' => 'confirmed', 'active' => 'active',
            'cancelling' => 'cancelling', 'cancelled' => 'cancelled', 'expired' => 'expired',
            default => 'unregistered'
        };
        $statusLabel = match($subscription?->status ?? 'none') {
            'pending' => '受付済', 'confirmed' => '決済確認済', 'active' => '提供中',
            'cancelling' => '解約申請中', 'cancelled' => '解約済', 'expired' => '期限切れ',
            default => '未登録'
        };
        
        return compact('user', 'subscription', 'plan', 'statusClass', 'statusLabel');
    }

    /**
     * Display the mypage dashboard.
     */
    public function index()
    {
        $data = $this->getCommonData();
        $user = $data['user'];
        $plan = $data['plan'];
        
        $orders = $user->orders()->latest()->take(5)->get();
        $payments = $user->payments()->latest()->take(10)->get();
        
        $downloads = Download::where(function($q) use ($user, $plan) {
            $q->where('is_public', true)
              ->orWhere('user_id', $user->id);
            if ($plan) {
                $q->orWhere('plan_required', $plan->slug);
                if ($plan->slug === 'premium') {
                    $q->orWhere('plan_required', 'basic');
                }
            }
        })->where('is_active', true)->get();
        
        $currentMonthPayments = $user->payments()
            ->whereMonth('billing_date', now()->month)
            ->whereYear('billing_date', now()->year)
            ->sum('amount');
        $nextBillingDate = $data['subscription']?->expires_at;
        
        return view('flowgram.mypage.dashboard', array_merge($data, compact(
            'orders', 'payments', 'downloads', 'currentMonthPayments', 'nextBillingDate'
        )));
    }

    /**
     * Show orders list.
     */
    public function orders()
    {
        $data = $this->getCommonData();
        $orders = $data['user']->orders()->latest()->paginate(20);
        
        return view('flowgram.mypage.orders', array_merge($data, compact('orders')));
    }

    /**
     * Show billing/payments.
     */
    public function billing()
    {
        $data = $this->getCommonData();
        $payments = $data['user']->payments()->latest()->paginate(20);
        
        $currentMonthPayments = $data['user']->payments()
            ->whereMonth('billing_date', now()->month)
            ->whereYear('billing_date', now()->year)
            ->sum('amount');
        $nextBillingDate = $data['subscription']?->expires_at;
        
        return view('flowgram.mypage.billing', array_merge($data, compact(
            'payments', 'currentMonthPayments', 'nextBillingDate'
        )));
    }

    /**
     * Show downloads.
     */
    public function downloads()
    {
        $data = $this->getCommonData();
        $user = $data['user'];
        $plan = $data['plan'];
        
        $downloads = Download::where(function($q) use ($user, $plan) {
            $q->where('is_public', true)
              ->orWhere('user_id', $user->id);
            if ($plan) {
                $q->orWhere('plan_required', $plan->slug);
                if ($plan->slug === 'premium') {
                    $q->orWhere('plan_required', 'basic');
                }
            }
        })->where('is_active', true)->get();
        
        return view('flowgram.mypage.downloads', array_merge($data, compact('downloads')));
    }

    /**
     * Download a file.
     */
    public function download(Download $download)
    {
        $user = Auth::user();
        
        if (!$download->canAccess($user)) {
            abort(403, 'このファイルにアクセスする権限がありません');
        }
        
        // Check if file exists using Storage facade
        if (!Storage::disk('local')->exists($download->file_path)) {
            return back()->with('error', 'ファイルが見つかりません。管理者にお問い合わせください。');
        }
        
        $download->incrementDownloads();
        
        $filePath = Storage::disk('local')->path($download->file_path);
        return response()->download($filePath, $download->file_name);
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        $data = $this->getCommonData();
        return view('flowgram.mypage.profile', $data);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);
        
        $user->update($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => '変更を保存しました']);
        }
        
        return redirect()->route('mypage.profile')->with('success', '変更を保存しました');
    }

    /**
     * Show password change form.
     */
    public function showPasswordForm()
    {
        $data = $this->getCommonData();
        return view('flowgram.mypage.password', $data);
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません']);
        }
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('mypage.profile')->with('success', 'パスワードを変更しました');
    }

    /**
     * Show support/contact page.
     */
    public function support()
    {
        $data = $this->getCommonData();
        return view('flowgram.mypage.support', $data);
    }

    /**
     * Submit contact/support inquiry.
     */
    public function submitContact(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'topics' => ['required', 'array'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);
        
        ContactInquiry::create([
            'user_id' => $user->id,
            'topics' => $validated['topics'],
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'お問い合わせを送信しました']);
        }
        
        return redirect()->route('mypage.support')->with('success', 'お問い合わせを送信しました');
    }

    /**
     * Show cancellation form.
     */
    public function showCancelForm()
    {
        $data = $this->getCommonData();
        return view('flowgram.mypage.cancel', $data);
    }

    /**
     * Request subscription cancellation.
     */
    public function requestCancellation(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscriptions()->where('status', 'active')->first();
        
        if (!$subscription) {
            return back()->with('error', 'アクティブなサブスクリプションがありません');
        }
        
        $validated = $request->validate([
            'cancel_reason' => ['nullable', 'string', 'max:1000'],
        ]);
        
        $subscription->update([
            'status' => 'cancelling',
            'cancelled_at' => now(),
            'cancel_reason' => $validated['cancel_reason'] ?? null,
        ]);
        
        return redirect()->route('mypage.billing')->with('success', '解約申請を受け付けました。サービス終了日までご利用いただけます。');
    }

    /**
     * Show delete account confirmation.
     */
    public function showDeleteAccountForm()
    {
        $data = $this->getCommonData();
        return view('flowgram.mypage.delete-account', $data);
    }

    /**
     * Delete user account.
     */
    public function deleteAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'string'],
            'confirm' => ['required', 'accepted'],
        ]);
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'パスワードが正しくありません']);
        }
        
        // Check for active subscription
        $activeSubscription = $user->subscriptions()
            ->whereIn('status', ['active', 'pending', 'confirmed'])
            ->first();
        
        if ($activeSubscription) {
            return back()->with('error', 'アクティブなサブスクリプションがあるため、アカウントを削除できません。先に解約申請を行ってください。');
        }
        
        // Logout and delete
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'アカウントを削除しました');
    }
}
