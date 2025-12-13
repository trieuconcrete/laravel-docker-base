<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'マイページ') | FLOWGRAM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Noto+Sans+JP:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --peach-glow: #FFD5D9;
      --blush-pink: #F8E7EF;
      --lavender-haze: #EEE7FF;
      --soft-mist: #F5F4F6;
      --white: #FFFFFF;
      --coral-rose: #FF8CA5;
      --coral-rose-hover: #FF7A96;
      --text-primary: #2F2F2F;
      --text-secondary: #666666;
      --text-light: #888888;
      --error: #E57373;
      --success: #81C784;
      --warning: #FFB74D;
      --info: #64B5F6;
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
      --sidebar-width: 260px;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Noto Sans JP', sans-serif; color: var(--text-primary); line-height: 1.8; background: var(--soft-mist); min-height: 100vh; }
    .font-en { font-family: 'Montserrat', sans-serif; font-weight: 300; }
    .dashboard { display: flex; min-height: 100vh; }
    
    /* Sidebar */
    .sidebar { width: var(--sidebar-width); background: var(--white); border-right: 1px solid rgba(0,0,0,0.05); position: fixed; top: 0; left: 0; height: 100vh; display: flex; flex-direction: column; z-index: 100; transition: transform 0.3s ease; }
    .sidebar-header { padding: 24px; border-bottom: 1px solid var(--soft-mist); }
    .sidebar-logo { font-family: 'Montserrat', sans-serif; font-size: 22px; letter-spacing: 2px; color: var(--text-primary); text-decoration: none; }
    .sidebar-logo span { color: var(--coral-rose); }
    .sidebar-nav { flex: 1; padding: 24px 16px; overflow-y: auto; }
    .nav-section { margin-bottom: 32px; }
    .nav-section-title { font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; padding: 0 12px; margin-bottom: 12px; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-secondary); text-decoration: none; font-size: 14px; border-radius: var(--radius-md); transition: all 0.3s ease; margin-bottom: 4px; }
    .nav-item:hover { background: var(--soft-mist); color: var(--text-primary); }
    .nav-item.active { background: linear-gradient(135deg, rgba(255,213,217,0.3) 0%, rgba(238,231,255,0.3) 100%); color: var(--coral-rose); }
    .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }
    .nav-item .badge { margin-left: auto; background: var(--coral-rose); color: white; font-size: 11px; padding: 2px 8px; border-radius: 10px; }
    .sidebar-footer { padding: 16px; border-top: 1px solid var(--soft-mist); }
    .user-card { display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--soft-mist); border-radius: var(--radius-md); }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--peach-glow) 0%, var(--lavender-haze) 100%); display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--coral-rose); }
    .user-info { flex: 1; min-width: 0; }
    .user-name { font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-plan { font-size: 11px; color: var(--text-light); }
    
    /* Main */
    .main-content { flex: 1; margin-left: var(--sidebar-width); min-height: 100vh; }
    .topbar { background: var(--white); padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 50; }
    .topbar-left { display: flex; align-items: center; gap: 16px; }
    .mobile-menu-btn { display: none; background: none; border: none; cursor: pointer; padding: 8px; }
    .mobile-menu-btn span { display: block; width: 24px; height: 2px; background: var(--text-primary); margin: 5px 0; }
    .page-title { font-size: 20px; font-weight: 300; }
    .topbar-right { display: flex; align-items: center; gap: 16px; }
    .search-box { display: flex; align-items: center; gap: 8px; background: var(--soft-mist); padding: 10px 16px; border-radius: 50px; width: 240px; }
    .search-box input { border: none; background: transparent; font-size: 14px; font-family: inherit; outline: none; width: 100%; }
    .search-box svg { color: var(--text-light); width: 18px; height: 18px; }
    .topbar-btn { width: 40px; height: 40px; border-radius: 50%; border: none; background: var(--soft-mist); cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative; transition: all 0.3s ease; }
    .topbar-btn:hover { background: var(--peach-glow); }
    .topbar-btn svg { width: 20px; height: 20px; color: var(--text-secondary); }
    .topbar-btn .notification-dot { position: absolute; top: 8px; right: 8px; width: 8px; height: 8px; background: var(--coral-rose); border-radius: 50%; }
    .content { padding: 32px; }
    
    /* Cards */
    .dashboard-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px; }
    .stat-card { background: var(--white); padding: 24px; border-radius: var(--radius-lg); transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
    .stat-icon { width: 48px; height: 48px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px; }
    .stat-icon.peach { background: rgba(255,213,217,0.5); }
    .stat-icon.lavender { background: rgba(238,231,255,0.5); }
    .stat-icon.mint { background: rgba(200,230,201,0.5); }
    .stat-icon.sky { background: rgba(187,222,251,0.5); }
    .stat-value { font-size: 28px; font-weight: 300; margin-bottom: 4px; }
    .stat-label { font-size: 13px; color: var(--text-light); }
    
    /* Sections */
    .section { background: var(--white); border-radius: var(--radius-lg); margin-bottom: 24px; }
    .section-header { padding: 20px 24px; border-bottom: 1px solid var(--soft-mist); display: flex; justify-content: space-between; align-items: center; }
    .section-title { font-size: 16px; font-weight: 400; }
    .section-action { font-size: 13px; color: var(--coral-rose); text-decoration: none; }
    .section-action:hover { text-decoration: underline; }
    .section-body { padding: 24px; }
    
    /* Status Badges */
    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
    .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-badge.pending { background: rgba(255,183,77,0.2); color: #F57C00; }
    .status-badge.confirmed { background: rgba(100,181,246,0.2); color: #1976D2; }
    .status-badge.active { background: rgba(129,199,132,0.2); color: #4CAF50; }
    .status-badge.cancelling { background: rgba(255,183,77,0.2); color: #FF9800; }
    .status-badge.cancelled { background: rgba(229,115,115,0.2); color: #E53935; }
    .status-badge.expired { background: rgba(158,158,158,0.2); color: #757575; }
    .status-badge.completed { background: rgba(129,199,132,0.2); color: #4CAF50; }
    .status-badge.processing { background: rgba(100,181,246,0.2); color: #1976D2; }
    .status-badge.paid { background: rgba(129,199,132,0.2); color: #4CAF50; }
    .status-badge.overdue { background: rgba(229,115,115,0.2); color: #E53935; }
    .status-badge.unregistered { background: rgba(158,158,158,0.2); color: #757575; }
    
    .plan-card { display: flex; align-items: center; justify-content: space-between; padding: 24px; background: linear-gradient(135deg, rgba(255,213,217,0.2) 0%, rgba(238,231,255,0.2) 100%); border-radius: var(--radius-md); margin-bottom: 24px; }
    .plan-info h4 { font-size: 18px; font-weight: 400; margin-bottom: 4px; }
    .plan-info p { font-size: 13px; color: var(--text-secondary); }
    .plan-price .amount { font-size: 28px; font-weight: 300; color: var(--coral-rose); }
    .plan-price .period { font-size: 13px; color: var(--text-light); }
    
    .quick-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .quick-action { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 24px; background: var(--soft-mist); border-radius: var(--radius-md); text-decoration: none; color: var(--text-primary); transition: all 0.3s ease; }
    .quick-action:hover { background: linear-gradient(135deg, rgba(255,213,217,0.3) 0%, rgba(238,231,255,0.3) 100%); transform: translateY(-4px); }
    .quick-action-icon { width: 48px; height: 48px; background: var(--white); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .quick-action span { font-size: 14px; }
    
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { padding: 16px; text-align: left; font-size: 14px; border-bottom: 1px solid var(--soft-mist); }
    .data-table th { font-weight: 400; color: var(--text-light); font-size: 12px; }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: var(--soft-mist); }
    
    .download-list { display: flex; flex-direction: column; gap: 12px; }
    .download-item { display: flex; align-items: center; gap: 16px; padding: 16px; background: var(--soft-mist); border-radius: var(--radius-md); transition: all 0.3s ease; }
    .download-item:hover { background: var(--peach-glow); }
    .download-icon { width: 40px; height: 40px; background: var(--white); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--coral-rose); }
    .download-info { flex: 1; }
    .download-info h5 { font-size: 14px; font-weight: 400; margin-bottom: 2px; }
    .download-info p { font-size: 12px; color: var(--text-light); }
    .download-btn { padding: 8px 16px; background: var(--white); border: 1px solid rgba(0,0,0,0.1); border-radius: 20px; font-size: 12px; color: var(--text-secondary); cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block; }
    .download-btn:hover { background: var(--coral-rose); color: white; border-color: var(--coral-rose); }
    
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 50px; font-size: 14px; font-family: inherit; text-decoration: none; transition: all 0.3s ease; cursor: pointer; border: none; }
    .btn-primary { background: var(--coral-rose); color: var(--white); }
    .btn-primary:hover { background: var(--coral-rose-hover); transform: translateY(-2px); }
    .btn-secondary { background: transparent; color: var(--text-secondary); border: 1px solid rgba(0,0,0,0.1); }
    .btn-secondary:hover { background: var(--soft-mist); }
    .btn-outline { background: transparent; color: var(--coral-rose); border: 1px solid var(--coral-rose); }
    .btn-outline:hover { background: var(--coral-rose); color: white; }
    .btn-danger { background: transparent; color: var(--error); border: 1px solid var(--error); }
    .btn-danger:hover { background: var(--error); color: white; }
    
    .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; color: var(--text-secondary); margin-bottom: 8px; }
    .form-input { width: 100%; padding: 12px 16px; font-size: 14px; font-family: inherit; border: 1px solid rgba(0,0,0,0.1); border-radius: var(--radius-md); background: var(--soft-mist); transition: all 0.3s ease; outline: none; }
    .form-input:focus { border-color: var(--coral-rose); background: var(--white); box-shadow: 0 0 0 3px rgba(255,140,165,0.1); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-row-3 { display: grid; grid-template-columns: 120px 1fr; gap: 16px; }
    textarea.form-input { min-height: 120px; resize: vertical; }
    
    .contact-options { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
    .contact-checkbox { display: flex; align-items: center; gap: 8px; padding: 8px 16px; background: var(--soft-mist); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; }
    .contact-checkbox:hover { background: var(--peach-glow); }
    .contact-checkbox input { display: none; }
    .contact-checkbox span { font-size: 13px; }
    .check-icon { opacity: 0; color: var(--coral-rose); transition: opacity 0.3s ease; }
    .contact-checkbox input:checked ~ .check-icon { opacity: 1; }
    .contact-checkbox.checked { background: var(--peach-glow); }
    
    .toast { position: fixed; top: 24px; right: 24px; padding: 16px 24px; background: var(--white); border-radius: var(--radius-md); box-shadow: 0 10px 40px rgba(0,0,0,0.1); transform: translateX(120%); transition: transform 0.4s ease; z-index: 1000; }
    .toast.show { transform: translateX(0); }
    .toast.success { border-left: 4px solid var(--success); }
    .toast.error { border-left: 4px solid var(--error); }
    
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 99; }
    .sidebar-overlay.active { display: block; }

    .alert { padding: 12px 16px; border-radius: var(--radius-md); margin-bottom: 24px; font-size: 14px; }
    .alert-success { background: rgba(129, 199, 132, 0.1); border: 1px solid var(--success); color: #388E3C; }
    .alert-error { background: rgba(229, 115, 115, 0.1); border: 1px solid var(--error); color: #C62828; }

    .billing-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
    .billing-card { background: linear-gradient(135deg, rgba(255,213,217,0.2) 0%, rgba(238,231,255,0.2) 100%); border-radius: var(--radius-md); padding: 20px; text-align: center; }
    .billing-card-label { font-size: 12px; color: var(--text-light); margin-bottom: 8px; }
    .billing-card-value { font-size: 24px; font-weight: 300; color: var(--coral-rose); }
    .billing-card-sub { font-size: 11px; color: var(--text-secondary); margin-top: 4px; }

    .no-data { text-align: center; padding: 48px 24px; color: var(--text-light); }
    .no-data-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
    .no-data p { font-size: 14px; }
    .no-data .btn { margin-top: 16px; }

    .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 24px; }
    .pagination a, .pagination span { padding: 8px 14px; border-radius: var(--radius-sm); font-size: 13px; text-decoration: none; }
    .pagination a { background: var(--white); color: var(--text-secondary); border: 1px solid rgba(0,0,0,0.1); }
    .pagination a:hover { background: var(--coral-rose); color: white; border-color: var(--coral-rose); }
    .pagination .active span { background: var(--coral-rose); color: white; }
    .pagination .disabled span { background: var(--soft-mist); color: var(--text-light); }
    
    @media (max-width: 1200px) { .dashboard-grid { grid-template-columns: repeat(2, 1fr); } .billing-summary { grid-template-columns: 1fr; } }
    @media (max-width: 1024px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.active { transform: translateX(0); }
      .main-content { margin-left: 0; }
      .mobile-menu-btn { display: block; }
      .search-box { display: none; }
      .grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .dashboard-grid { grid-template-columns: 1fr; }
      .quick-actions { grid-template-columns: 1fr; }
      .content { padding: 16px; }
      .topbar { padding: 16px; }
      .form-row { grid-template-columns: 1fr; }
      .form-row-3 { grid-template-columns: 1fr; }
    }
    @yield('styles')
  </style>
</head>
<body>
  @php
    $user = Auth::user();
    $subscription = $user->subscriptions()->latest()->first();
    $plan = $subscription?->plan;
    $downloadCount = \App\Models\Download::where(function($q) use ($user, $plan) {
        $q->where('is_public', true)->orWhere('user_id', $user->id);
        if ($plan) {
            $q->orWhere('plan_required', $plan->slug);
            if ($plan->slug === 'premium') $q->orWhere('plan_required', 'basic');
        }
    })->where('is_active', true)->count();
    
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
  @endphp

  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-logo">FLOW<span>GRAM</span></a>
      </div>
      <nav class="sidebar-nav">
        <div class="nav-section">
          <div class="nav-section-title">メイン</div>
          <a href="{{ route('mypage') }}" class="nav-item {{ request()->routeIs('mypage') && !request()->routeIs('mypage.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            ダッシュボード
          </a>
          <a href="{{ route('mypage.orders') }}" class="nav-item {{ request()->routeIs('mypage.orders*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            申込履歴
          </a>
          <a href="{{ route('mypage.downloads') }}" class="nav-item {{ request()->routeIs('mypage.downloads*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            ダウンロード資料
            @if($downloadCount > 0)
              <span class="badge">{{ $downloadCount }}</span>
            @endif
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">アカウント</div>
          <a href="{{ route('mypage.profile') }}" class="nav-item {{ request()->routeIs('mypage.profile*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            アカウント情報
          </a>
          <a href="{{ route('mypage.billing') }}" class="nav-item {{ request()->routeIs('mypage.billing*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            請求情報
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">サポート</div>
          <a href="{{ route('mypage.support') }}" class="nav-item {{ request()->routeIs('mypage.support*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            お問い合わせ
          </a>
          <a href="https://line.me" target="_blank" class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2C6.48 2 2 5.58 2 10c0 2.03.94 3.89 2.5 5.33V20l3.5-2c1.27.42 2.61.67 4 .67 5.52 0 10-3.58 10-8S17.52 2 12 2z"/></svg>
            LINEチャット
          </a>
        </div>
      </nav>
      <div class="sidebar-footer">
        <div class="user-card">
          <div class="user-avatar">{{ mb_substr($user->name ?? 'U', 0, 1) }}</div>
          <div class="user-info">
            <div class="user-name">{{ $user->name ?? 'ゲスト' }}</div>
            <div class="user-plan">{{ $plan?->name ?? '未登録' }}</div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="topbar">
        <div class="topbar-left">
          <button class="mobile-menu-btn" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
          <h1 class="page-title">@yield('page_title', 'マイページ')</h1>
        </div>
        <div class="topbar-right">
          <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" placeholder="検索...">
          </div>
          <button class="topbar-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notification-dot"></span>
          </button>
          <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="topbar-btn" title="ログアウト">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
          </form>
        </div>
      </header>

      <div class="content">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
      </div>
    </main>
  </div>

  <div class="toast" id="toast"><span id="toastMessage"></span></div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebarOverlay').classList.toggle('active');
    }
    function showToast(message, type) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = message;
      toast.className = 'toast ' + type + ' show';
      setTimeout(() => toast.classList.remove('show'), 3000);
    }
    @yield('scripts')
  </script>
</body>
</html>

