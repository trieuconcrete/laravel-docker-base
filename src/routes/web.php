<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MyPage\MyPageController;

// Admin Controllers
use App\Http\Controllers\Flowgram\Admin\DashboardController;
use App\Http\Controllers\Flowgram\Admin\UserController;
use App\Http\Controllers\Flowgram\Admin\OrderController;
use App\Http\Controllers\Flowgram\Admin\SubscriptionController;
use App\Http\Controllers\Flowgram\Admin\DownloadController;
use App\Http\Controllers\Flowgram\Admin\ContactInquiryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==============================================
// Public Routes - FLOWGRAM
// ==============================================

Route::get('/', function () {
    return view('flowgram.index');
});

// Legal Pages
Route::prefix('legal')->group(function () {
    Route::get('/tokushoho', fn() => view('flowgram.legal.tokushoho'))->name('legal.tokushoho');
    Route::get('/privacy', fn() => view('flowgram.legal.privacy'))->name('legal.privacy');
    Route::get('/terms', fn() => view('flowgram.legal.terms'))->name('legal.terms');
});

// Contact Page (Public)
Route::get('/contact', fn() => view('flowgram.contact'))->name('contact');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $user = Auth::user();
    
    $validated = $request->validate([
        'topics' => ['required', 'array'],
        'name' => $user ? ['nullable'] : ['required', 'string', 'max:255'],
        'email' => $user ? ['nullable'] : ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'subject' => ['required', 'string', 'max:255'],
        'message' => ['required', 'string'],
    ]);
    
    \App\Models\ContactInquiry::create([
        'user_id' => $user?->id,
        'topics' => $validated['topics'],
        'name' => $validated['name'] ?? $user?->name ?? 'Guest',
        'email' => $validated['email'] ?? $user?->email ?? '',
        'phone' => $validated['phone'] ?? $user?->phone,
        'subject' => $validated['subject'],
        'message' => $validated['message'],
        'status' => 'new',
    ]);
    
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['message' => 'お問い合わせを送信しました']);
    }
    
    return redirect()->back()->with('success', 'お問い合わせを受け付けました。担当者より折り返しご連絡いたします。');
})->name('contact.submit');

// ==============================================
// Guest Routes (Login/Register)
// ==============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('flowgram.login'))->name('login');
    Route::get('/register', fn() => view('flowgram.register'))->name('register.form');
    
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('mypage'));
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    });
    
    Route::post('/register', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'role' => 'user',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('mypage')->with('success', '登録が完了しました！');
    })->name('register');
});

// Password Reset
Route::get('/forgot-password', fn() => view('auth.forgot-password'))
    ->middleware('guest')
    ->name('password.request');

// ==============================================
// Authenticated Routes
// ==============================================

Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // ==============================================
    // MyPage Routes (User only)
    // ==============================================
    Route::prefix('mypage')->name('mypage')->middleware('user')->group(function () {
        Route::get('/', [MyPageController::class, 'index']);
        Route::get('/orders', [MyPageController::class, 'orders'])->name('.orders');
        Route::get('/downloads', [MyPageController::class, 'downloads'])->name('.downloads');
        Route::get('/downloads/{download}/file', [MyPageController::class, 'download'])->name('.download');
        Route::get('/profile', [MyPageController::class, 'profile'])->name('.profile');
        Route::put('/profile', [MyPageController::class, 'updateProfile'])->name('.profile.update');
        Route::get('/password', [MyPageController::class, 'showPasswordForm'])->name('.password');
        Route::put('/password', [MyPageController::class, 'updatePassword'])->name('.password.update');
        Route::get('/delete-account', [MyPageController::class, 'showDeleteAccountForm'])->name('.delete-account');
        Route::delete('/delete-account', [MyPageController::class, 'deleteAccount'])->name('.delete-account.submit');
        Route::get('/billing', [MyPageController::class, 'billing'])->name('.billing');
        Route::get('/cancel', [MyPageController::class, 'showCancelForm'])->name('.cancel');
        Route::post('/cancel', [MyPageController::class, 'requestCancellation'])->name('.cancel.submit');
        Route::get('/support', [MyPageController::class, 'support'])->name('.support');
        Route::post('/support', [MyPageController::class, 'submitContact'])->name('.contact.submit');
    });

    // ==============================================
    // Admin Routes (Admin only)
    // ==============================================
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // 会員管理 (Users)
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        
        // 申込管理 (Orders)
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        });
        
        // サブスクリプション管理 (Subscriptions)
        Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
            Route::post('/', [SubscriptionController::class, 'store'])->name('store');
            Route::put('/{subscription}', [SubscriptionController::class, 'update'])->name('update');
        });
        
        // 資料アップロード (Downloads)
        Route::prefix('downloads')->name('downloads.')->group(function () {
            Route::get('/', [DownloadController::class, 'index'])->name('index');
            Route::post('/', [DownloadController::class, 'store'])->name('store');
            Route::get('/{download}/download', [DownloadController::class, 'download'])->name('download');
            Route::put('/{download}', [DownloadController::class, 'update'])->name('update');
            Route::delete('/{download}', [DownloadController::class, 'destroy'])->name('destroy');
        });
        
        // お問い合わせ管理 (Inquiries)
        Route::prefix('inquiries')->name('inquiries.')->group(function () {
            Route::get('/', [ContactInquiryController::class, 'index'])->name('index');
            Route::get('/{inquiry}', [ContactInquiryController::class, 'show'])->name('show');
            Route::put('/{inquiry}', [ContactInquiryController::class, 'update'])->name('update');
            Route::delete('/{inquiry}', [ContactInquiryController::class, 'destroy'])->name('destroy');
        });
    });
});

// Social Login (placeholder)
Route::get('/auth/{provider}', fn($provider) => redirect()->route('login')->with('error', 'Social login not configured yet.'))
    ->name('social.login');
