<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Đăng ký thành công!');
    })->name('register');
});

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Profile & Settings
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('profile');
        
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
        
        // CMS Routes
        Route::prefix('cms')->name('cms.')->group(function () {
            Route::get('/posts', function () {
                return view('admin.modules.cms.posts');
            })->name('posts');
            
            Route::get('/categories', function () {
                return view('admin.modules.cms.categories');
            })->name('categories');
            
            Route::get('/media', function () {
                return view('admin.modules.cms.media');
            })->name('media');
            
            Route::get('/pages', function () {
                return view('admin.modules.cms.pages');
            })->name('pages');
        });
        
        // CRM Routes
        Route::prefix('crm')->name('crm.')->group(function () {
            Route::get('/contacts', function () {
                return view('admin.modules.crm.contacts');
            })->name('contacts');
            
            Route::get('/leads', function () {
                return view('admin.modules.crm.leads');
            })->name('leads');
            
            Route::get('/opportunities', function () {
                return view('admin.modules.crm.opportunities');
            })->name('opportunities');
            
            Route::get('/companies', function () {
                return view('admin.modules.crm.companies');
            })->name('companies');
            
            Route::get('/deals', function () {
                return view('admin.modules.crm.deals');
            })->name('deals');
            
            Route::get('/activities', function () {
                return view('admin.modules.crm.activities');
            })->name('activities');
        });
        
        // E-commerce Routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', function () {
                return view('admin.modules.ecommerce.products.index');
            })->name('index');
            
            Route::get('/create', function () {
                return view('admin.modules.ecommerce.products.create');
            })->name('create');
        });
        
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', function () {
                return view('admin.modules.ecommerce.orders.index');
            })->name('index');
        });
        
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', function () {
                return view('admin.modules.ecommerce.customers.index');
            })->name('index');
        });
        
        Route::get('/inventory', function () {
            return view('admin.modules.ecommerce.inventory');
        })->name('inventory.index');
        
        Route::get('/analytics', function () {
            return view('admin.modules.ecommerce.analytics');
        })->name('analytics.index');
        
        // Job Portal Routes
        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/postings', function () {
                return view('admin.modules.jobs.postings');
            })->name('postings');
            
            Route::get('/applications', function () {
                return view('admin.modules.jobs.applications');
            })->name('applications');
            
            Route::get('/employers', function () {
                return view('admin.modules.jobs.employers');
            })->name('employers');
            
            Route::get('/workflow', function () {
                return view('admin.modules.jobs.workflow');
            })->name('workflow');
            
            Route::get('/create', function () {
                return view('admin.modules.jobs.create');
            })->name('create');
        });
        
        // User Management Routes
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', function () {
                return view('admin.modules.users.index');
            })->name('index');
            
            Route::get('/create', function () {
                return view('admin.modules.users.create');
            })->name('create');
            
            Route::get('/roles', function () {
                return view('admin.modules.users.roles');
            })->name('roles');
            
            Route::get('/logs', function () {
                return view('admin.modules.users.logs');
            })->name('logs');
        });
        
        // CMS Posts Routes
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/create', function () {
                return view('admin.modules.cms.posts-create');
            })->name('create');
        });
    });
});

// Social Login Routes (placeholder - requires socialite package)
Route::get('/auth/{provider}', function ($provider) {
    // return Socialite::driver($provider)->redirect();
    return redirect()->route('login')->with('error', 'Social login not configured yet.');
})->name('social.login');
