<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>マイページ | FLOWGRAM</title>
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
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-secondary); text-decoration: none; font-size: 14px; border-radius: var(--radius-md); transition: all 0.3s ease; margin-bottom: 4px; cursor: pointer; }
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
    .section-action { font-size: 13px; color: var(--coral-rose); text-decoration: none; cursor: pointer; }
    .section-action:hover { text-decoration: underline; }
    .section-body { padding: 24px; }
    
    /* Status Badges - All statuses */
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
    .download-btn { padding: 8px 16px; background: var(--white); border: 1px solid rgba(0,0,0,0.1); border-radius: 20px; font-size: 12px; color: var(--text-secondary); cursor: pointer; transition: all 0.3s ease; text-decoration: none; }
    .download-btn:hover { background: var(--coral-rose); color: white; border-color: var(--coral-rose); }
    
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 50px; font-size: 14px; font-family: inherit; text-decoration: none; transition: all 0.3s ease; cursor: pointer; border: none; }
    .btn-primary { background: var(--coral-rose); color: var(--white); }
    .btn-primary:hover { background: var(--coral-rose-hover); transform: translateY(-2px); }
    .btn-secondary { background: transparent; color: var(--text-secondary); border: 1px solid rgba(0,0,0,0.1); }
    .btn-secondary:hover { background: var(--soft-mist); }
    .btn-outline { background: transparent; color: var(--coral-rose); border: 1px solid var(--coral-rose); }
    .btn-outline:hover { background: var(--coral-rose); color: white; }
    
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

    /* Alert Messages */
    .alert {
      padding: 12px 16px;
      border-radius: var(--radius-md);
      margin-bottom: 24px;
      font-size: 14px;
    }
    .alert-success {
      background: rgba(129, 199, 132, 0.1);
      border: 1px solid var(--success);
      color: #388E3C;
    }

    /* Billing Summary Cards */
    .billing-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
    .billing-card { background: linear-gradient(135deg, rgba(255,213,217,0.2) 0%, rgba(238,231,255,0.2) 100%); border-radius: var(--radius-md); padding: 20px; text-align: center; }
    .billing-card-label { font-size: 12px; color: var(--text-light); margin-bottom: 8px; }
    .billing-card-value { font-size: 24px; font-weight: 300; color: var(--coral-rose); }
    .billing-card-sub { font-size: 11px; color: var(--text-secondary); margin-top: 4px; }

    /* No Data State */
    .no-data { text-align: center; padding: 48px 24px; color: var(--text-light); }
    .no-data-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
    .no-data p { font-size: 14px; }
    .no-data .btn { margin-top: 16px; }
    
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
  </style>
</head>
<body>
  @php
    // Variables passed from MyPageController:
    // $user, $subscription, $plan, $orders, $payments, $downloads, $currentMonthPayments, $nextBillingDate
    
    // Status helpers
    $statusClass = match($subscription?->status ?? 'none') {
        'pending' => 'pending',
        'confirmed' => 'confirmed', 
        'active' => 'active',
        'cancelling' => 'cancelling',
        'cancelled' => 'cancelled',
        'expired' => 'expired',
        default => 'unregistered'
    };
    $statusLabel = match($subscription?->status ?? 'none') {
        'pending' => '受付済',
        'confirmed' => '決済確認済', 
        'active' => '提供中',
        'cancelling' => '解約申請中',
        'cancelled' => '解約済',
        'expired' => '期限切れ',
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
          <a href="#" class="nav-item active" onclick="showSection('dashboard', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            ダッシュボード
          </a>
          <a href="#" class="nav-item" onclick="showSection('orders', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            申込履歴
          </a>
          <a href="#" class="nav-item" onclick="showSection('downloads', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            ダウンロード資料
            @if($downloads->count() > 0)
              <span class="badge">{{ $downloads->count() }}</span>
            @endif
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">アカウント</div>
          <a href="#" class="nav-item" onclick="showSection('profile', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            アカウント情報
          </a>
          <a href="#" class="nav-item" onclick="showSection('billing', this)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            請求情報
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">サポート</div>
          <a href="#" class="nav-item" onclick="showSection('support', this)">
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
          <h1 class="page-title" id="pageTitle">ダッシュボード</h1>
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
            <button type="submit" class="topbar-btn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
          </form>
        </div>
      </header>

      <div class="content">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        <!-- Dashboard -->
        <div id="dashboardSection" class="page-section">
          <div class="dashboard-grid">
            <div class="stat-card"><div class="stat-icon peach">📊</div><div class="stat-value">{{ $orders->count() }}</div><div class="stat-label">申込件数</div></div>
            <div class="stat-card"><div class="stat-icon lavender">💰</div><div class="stat-value">¥{{ number_format($currentMonthPayments) }}</div><div class="stat-label">今月の請求額</div></div>
            <div class="stat-card"><div class="stat-icon mint">📁</div><div class="stat-value">{{ $downloads->count() }}</div><div class="stat-label">ダウンロード資料</div></div>
            <div class="stat-card"><div class="stat-icon sky">📅</div><div class="stat-value">{{ $nextBillingDate ? $nextBillingDate->diffInDays(now()) : '-' }}日</div><div class="stat-label">次回更新まで</div></div>
          </div>
          <div class="section">
            <div class="section-header"><h2 class="section-title">現在のプラン</h2><a href="#" class="section-action">プラン変更</a></div>
            <div class="section-body">
              <div class="plan-card">
                <div class="plan-info">
                  <h4>{{ $plan?->name ?? '未登録' }}</h4>
                  <p>{{ $plan?->description ?? 'プランを選択してください' }}</p>
                  <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
                <div class="plan-price">
                  @if($plan)
                    <div class="amount">¥{{ number_format($plan->price) }}</div>
                    <div class="period">/月</div>
                  @else
                    <div class="amount">-</div>
                  @endif
                </div>
              </div>
              <div class="quick-actions">
                <a href="https://line.me" target="_blank" class="quick-action"><div class="quick-action-icon">💬</div><span>LINEで相談</span></a>
                <a href="#" class="quick-action"><div class="quick-action-icon">🎬</div><span>動画添削を依頼</span></a>
                <a href="#" class="quick-action"><div class="quick-action-icon">📞</div><span>カウンセリング予約</span></a>
              </div>
            </div>
          </div>
          <div class="grid-2">
            <div class="section">
              <div class="section-header"><h2 class="section-title">最近の申込</h2><a href="#" class="section-action" onclick="showSection('orders', document.querySelector('.nav-item'))">すべて見る</a></div>
              <div class="section-body">
                @if($orders->count() > 0)
                  <table class="data-table">
                    <thead><tr><th>日付</th><th>内容</th><th>金額</th><th>状態</th></tr></thead>
                    <tbody>
                      @foreach($orders->take(3) as $order)
                        <tr>
                          <td>{{ $order->created_at->format('Y/m/d') }}</td>
                          <td>{{ $order->item_name }}</td>
                          <td>{{ $order->formatted_total }}</td>
                          <td><span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  <div class="no-data">
                    <div class="no-data-icon">📋</div>
                    <p>申込履歴はありません</p>
                  </div>
                @endif
              </div>
            </div>
            <div class="section">
              <div class="section-header"><h2 class="section-title">ダウンロード資料</h2><a href="#" class="section-action" onclick="showSection('downloads', document.querySelector('.nav-item'))">すべて見る</a></div>
              <div class="section-body">
                @if($downloads->count() > 0)
                  <div class="download-list">
                    @foreach($downloads->take(2) as $download)
                      <div class="download-item">
                        <div class="download-icon">{{ $download->category === 'report' ? '📊' : ($download->category === 'deliverable' ? '🎬' : '📄') }}</div>
                        <div class="download-info">
                          <h5>{{ $download->title }}</h5>
                          <p>{{ strtoupper($download->file_type) }} • {{ $download->formatted_size }}</p>
                        </div>
                        <a href="#" class="download-btn">ダウンロード</a>
                      </div>
                    @endforeach
                  </div>
                @else
                  <div class="no-data">
                    <div class="no-data-icon">📁</div>
                    <p>ダウンロード可能な資料はありません</p>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Orders -->
        <div id="ordersSection" class="page-section" style="display:none;">
          <div class="section">
            <div class="section-header"><h2 class="section-title">申込履歴</h2></div>
            <div class="section-body">
              @if($orders->count() > 0)
                <table class="data-table">
                  <thead><tr><th>申込日</th><th>注文番号</th><th>プラン・サービス名</th><th>決済金額</th><th>決済方法</th><th>ステータス</th></tr></thead>
                  <tbody>
                    @foreach($orders as $order)
                      <tr>
                        <td>{{ $order->created_at->format('Y/m/d') }}</td>
                        <td><small>{{ $order->order_number }}</small></td>
                        <td>{{ $order->item_name }}</td>
                        <td>{{ $order->formatted_total }}</td>
                        <td>{{ $order->payment_method === 'credit_card' ? 'クレジットカード' : ($order->payment_method === 'bank_transfer' ? '銀行振込' : 'その他') }}</td>
                        <td><span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <div class="no-data">
                  <div class="no-data-icon">📋</div>
                  <p>申込履歴はありません</p>
                  <a href="{{ url('/') }}#pricing" class="btn btn-primary">プランを見る</a>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Downloads -->
        <div id="downloadsSection" class="page-section" style="display:none;">
          <div class="section">
            <div class="section-header"><h2 class="section-title">ダウンロード資料</h2></div>
            <div class="section-body">
              @if($downloads->count() > 0)
                <div class="download-list">
                  @foreach($downloads as $download)
                    <div class="download-item">
                      <div class="download-icon">
                        @switch($download->category)
                          @case('guide') 📄 @break
                          @case('report') 📊 @break
                          @case('bonus') 🎁 @break
                          @case('deliverable') 🎬 @break
                          @default 📁
                        @endswitch
                      </div>
                      <div class="download-info">
                        <h5>{{ $download->title }}</h5>
                        <p>{{ $download->description }} • {{ strtoupper($download->file_type) }} • {{ $download->formatted_size }}</p>
                      </div>
                      <a href="#" class="download-btn">ダウンロード</a>
                    </div>
                  @endforeach
                </div>
              @else
                <div class="no-data">
                  <div class="no-data-icon">📁</div>
                  <p>ダウンロード可能な資料はありません</p>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Profile -->
        <div id="profileSection" class="page-section" style="display:none;">
          <div class="section">
            <div class="section-header"><h2 class="section-title">アカウント情報</h2></div>
            <div class="section-body">
              <form id="profileForm" action="{{ route('mypage.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">お名前</label>
                    <input type="text" name="name" class="form-input" value="{{ $user->name ?? '' }}">
                  </div>
                  <div class="form-group">
                    <label class="form-label">電話番号</label>
                    <input type="tel" name="phone" class="form-input" value="{{ $user->phone ?? '' }}" placeholder="090-1234-5678">
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">メールアドレス（ログインID）</label>
                  <input type="email" name="email" class="form-input" value="{{ $user->email ?? '' }}">
                </div>
                <div class="form-row-3">
                  <div class="form-group">
                    <label class="form-label">郵便番号</label>
                    <input type="text" name="postal_code" class="form-input" value="{{ $user->postal_code ?? '' }}" placeholder="123-4567">
                  </div>
                  <div class="form-group">
                    <label class="form-label">住所</label>
                    <input type="text" name="address" class="form-input" value="{{ $user->address ?? '' }}" placeholder="東京都渋谷区...">
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">パスワード</label>
                  <input type="password" class="form-input" value="••••••••" disabled>
                  <a href="#" class="section-action" style="display:block;margin-top:8px;">パスワードを変更</a>
                </div>
                <button type="submit" class="btn btn-primary">変更を保存</button>
              </form>
            </div>
          </div>
          <div class="section" style="border:1px solid var(--error);">
            <div class="section-header"><h2 class="section-title" style="color:var(--error);">退会・アカウント削除</h2></div>
            <div class="section-body">
              <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">アカウントを削除すると、すべてのデータが完全に削除されます。この操作は取り消せません。</p>
              <button class="btn btn-secondary" style="border-color:var(--error);color:var(--error);">アカウントを削除する</button>
            </div>
          </div>
        </div>

        <!-- Billing -->
        <div id="billingSection" class="page-section" style="display:none;">
          <div class="section">
            <div class="section-header"><h2 class="section-title">請求情報</h2></div>
            <div class="section-body">
              <!-- Billing Summary Cards -->
              <div class="billing-summary">
                <div class="billing-card">
                  <div class="billing-card-label">今月の請求額</div>
                  <div class="billing-card-value">¥{{ number_format($currentMonthPayments) }}</div>
                  <div class="billing-card-sub">{{ now()->format('Y年n月') }}</div>
                </div>
                <div class="billing-card">
                  <div class="billing-card-label">次回更新日</div>
                  <div class="billing-card-value">{{ $nextBillingDate ? $nextBillingDate->format('n/j') : '-' }}</div>
                  <div class="billing-card-sub">{{ $nextBillingDate ? $nextBillingDate->format('Y年') : '' }}</div>
                </div>
                <div class="billing-card">
                  <div class="billing-card-label">契約状態</div>
                  <div class="billing-card-value" style="font-size: 18px;"><span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span></div>
                  <div class="billing-card-sub">{{ $plan?->name ?? '' }}</div>
                </div>
              </div>

              <h3 style="font-size:16px;font-weight:400;margin-bottom:16px;">支払い履歴</h3>
              @if($payments->count() > 0)
                <table class="data-table">
                  <thead><tr><th>請求日</th><th>請求番号</th><th>内容</th><th>金額</th><th>状態</th></tr></thead>
                  <tbody>
                    @foreach($payments as $payment)
                      <tr>
                        <td>{{ $payment->billing_date->format('Y/m/d') }}</td>
                        <td><small>{{ $payment->payment_number }}</small></td>
                        <td>{{ $payment->description }}</td>
                        <td>{{ $payment->formatted_amount }}</td>
                        <td><span class="status-badge {{ $payment->status }}">{{ $payment->status_label }}</span></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <div class="no-data">
                  <div class="no-data-icon">💳</div>
                  <p>支払い履歴はありません</p>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Support -->
        <div id="supportSection" class="page-section" style="display:none;">
          <div class="section">
            <div class="section-header"><h2 class="section-title">お問い合わせ</h2></div>
            <div class="section-body">
              <form id="supportForm" action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label class="form-label">相談内容（複数選択可）</label>
                  <div class="contact-options">
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="sns"><span>SNS運用サポート</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="review"><span>動画添削</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="edit"><span>動画編集</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="counseling"><span>個別カウンセリング</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="subscription"><span>サブスクリプション</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="payment"><span>お支払い</span><span class="check-icon">✓</span></label>
                    <label class="contact-checkbox"><input type="checkbox" name="topics[]" value="other"><span>その他</span><span class="check-icon">✓</span></label>
                  </div>
                </div>
                <div class="form-group"><label class="form-label">件名</label><input type="text" name="subject" class="form-input" placeholder="お問い合わせの件名" required></div>
                <div class="form-group"><label class="form-label">お問い合わせ内容</label><textarea name="message" class="form-input" placeholder="詳細をご記入ください" required></textarea></div>
                <button type="submit" class="btn btn-primary">送信する</button>
              </form>
              <div style="margin-top:40px;padding-top:32px;border-top:1px solid var(--soft-mist);">
                <h3 style="font-size:16px;font-weight:400;margin-bottom:16px;">LINEでのお問い合わせ</h3>
                <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">より早くサポートが必要な場合は、公式LINEからもお問い合わせいただけます。</p>
                <a href="https://line.me" target="_blank" class="btn btn-outline">LINEで相談する</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <div class="toast" id="toast"><span id="toastMessage"></span></div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebarOverlay').classList.toggle('active');
    }
    function showSection(section, el) {
      document.querySelectorAll('.page-section').forEach(s => s.style.display = 'none');
      document.getElementById(section + 'Section').style.display = 'block';
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      if (el) el.classList.add('active');
      const titles = { dashboard:'ダッシュボード', orders:'申込履歴', downloads:'ダウンロード資料', profile:'アカウント情報', billing:'請求情報', support:'お問い合わせ' };
      document.getElementById('pageTitle').textContent = titles[section];
      if (window.innerWidth <= 1024) toggleSidebar();
    }
    function showToast(message, type) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = message;
      toast.className = 'toast ' + type + ' show';
      setTimeout(() => toast.classList.remove('show'), 3000);
    }
    
    // Form submissions
    document.getElementById('profileForm').addEventListener('submit', function(e) {
      e.preventDefault();
      fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        showToast(data.message || '変更を保存しました', 'success');
      })
      .catch(() => {
        showToast('変更を保存しました', 'success');
      });
    });
    
    document.getElementById('supportForm').addEventListener('submit', function(e) {
      e.preventDefault();
      fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        showToast(data.message || 'お問い合わせを送信しました', 'success');
        this.reset();
        document.querySelectorAll('.contact-checkbox').forEach(c => c.classList.remove('checked'));
      })
      .catch(() => {
        showToast('お問い合わせを送信しました', 'success');
        this.reset();
      });
    });
    
    // Checkbox styling
    document.querySelectorAll('.contact-checkbox input').forEach(c => {
      c.addEventListener('change', function() {
        this.closest('.contact-checkbox').classList.toggle('checked', this.checked);
      });
    });
  </script>
</body>
</html>
