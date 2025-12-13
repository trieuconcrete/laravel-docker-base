<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', '管理画面') | FLOWGRAM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Noto+Sans+JP:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root{--peach-glow:#FFD5D9;--blush-pink:#F8E7EF;--lavender-haze:#EEE7FF;--soft-mist:#F5F4F6;--white:#FFFFFF;--coral-rose:#FF8CA5;--coral-rose-hover:#FF7A96;--text-primary:#2F2F2F;--text-secondary:#666666;--text-light:#888888;--error:#E57373;--success:#81C784;--warning:#FFB74D;--info:#64B5F6;--radius-sm:8px;--radius-md:12px;--radius-lg:16px;--sidebar-width:260px}
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Noto Sans JP',sans-serif;color:var(--text-primary);line-height:1.6;background:#f8f9fa;min-height:100vh}
    .admin-layout{display:flex;min-height:100vh}
    .sidebar{width:var(--sidebar-width);background:var(--text-primary);position:fixed;top:0;left:0;height:100vh;display:flex;flex-direction:column;z-index:100;transition:transform .3s ease}
    .sidebar-header{padding:20px 24px;border-bottom:1px solid rgba(255,255,255,.1)}
    .sidebar-logo{font-family:'Montserrat',sans-serif;font-size:20px;letter-spacing:2px;color:var(--white);text-decoration:none;display:flex;align-items:center;gap:8px}
    .admin-badge{background:var(--coral-rose);color:white;font-size:10px;padding:2px 8px;border-radius:10px;margin-left:8px}
    .sidebar-nav{flex:1;padding:16px 12px;overflow-y:auto}
    .nav-section{margin-bottom:24px}
    .nav-section-title{font-size:10px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px}
    .nav-item{display:flex;align-items:center;gap:12px;padding:10px 12px;color:rgba(255,255,255,.7);text-decoration:none;font-size:13px;border-radius:var(--radius-sm);transition:all .2s ease;margin-bottom:2px}
    .nav-item:hover{background:rgba(255,255,255,.1);color:var(--white)}
    .nav-item.active{background:var(--coral-rose);color:var(--white)}
    .nav-item svg{width:18px;height:18px;flex-shrink:0;opacity:.8}
    .nav-item .badge{margin-left:auto;background:rgba(255,255,255,.2);color:white;font-size:10px;padding:2px 6px;border-radius:8px}
    .sidebar-footer{padding:16px;border-top:1px solid rgba(255,255,255,.1)}
    .admin-user{display:flex;align-items:center;gap:12px}
    .admin-avatar{width:36px;height:36px;border-radius:50%;background:var(--coral-rose);display:flex;align-items:center;justify-content:center;color:white;font-size:14px}
    .admin-info{flex:1}
    .admin-name{font-size:13px;color:var(--white)}
    .admin-role{font-size:11px;color:rgba(255,255,255,.5)}
    .main-content{flex:1;margin-left:var(--sidebar-width)}
    .topbar{background:var(--white);padding:12px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(0,0,0,.05);position:sticky;top:0;z-index:50}
    .topbar-left{display:flex;align-items:center;gap:16px}
    .mobile-menu-btn{display:none;background:none;border:none;cursor:pointer;padding:8px}
    .mobile-menu-btn span{display:block;width:20px;height:2px;background:var(--text-primary);margin:4px 0}
    .breadcrumb{font-size:13px;color:var(--text-light)}
    .breadcrumb a{color:var(--text-secondary);text-decoration:none}
    .breadcrumb a:hover{color:var(--coral-rose)}
    .topbar-right{display:flex;align-items:center;gap:12px}
    .search-box{display:flex;align-items:center;gap:8px;background:var(--soft-mist);padding:8px 14px;border-radius:8px;width:220px}
    .search-box input{border:none;background:transparent;font-size:13px;font-family:inherit;outline:none;width:100%}
    .search-box svg{color:var(--text-light);width:16px;height:16px}
    .topbar-btn{width:36px;height:36px;border-radius:8px;border:none;background:var(--soft-mist);cursor:pointer;display:flex;align-items:center;justify-content:center;position:relative;transition:all .2s ease}
    .topbar-btn:hover{background:var(--peach-glow)}
    .topbar-btn svg{width:18px;height:18px;color:var(--text-secondary)}
    .notification-dot{position:absolute;top:6px;right:6px;width:6px;height:6px;background:var(--coral-rose);border-radius:50%}
    .content{padding:24px}
    .page-header{margin-bottom:24px}
    .page-header.flex{display:flex;justify-content:space-between;align-items:center}
    .page-title{font-size:22px;font-weight:400;margin-bottom:4px}
    .page-subtitle{font-size:13px;color:var(--text-light)}
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
    .stat-card{background:var(--white);padding:20px;border-radius:var(--radius-md);display:flex;align-items:flex-start;gap:16px}
    .stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px}
    .stat-icon.rose{background:rgba(255,140,165,.15)}
    .stat-icon.blue{background:rgba(100,181,246,.15)}
    .stat-icon.green{background:rgba(129,199,132,.15)}
    .stat-icon.orange{background:rgba(255,183,77,.15)}
    .stat-content{}
    .stat-value{font-size:24px;font-weight:500;margin-bottom:2px}
    .stat-label{font-size:12px;color:var(--text-light)}
    .stat-change{font-size:11px;margin-top:4px}
    .stat-change.up{color:var(--success)}
    .stat-change.down{color:var(--error)}
    .card{background:var(--white);border-radius:var(--radius-md);margin-bottom:16px}
    .card-header{padding:16px 20px;border-bottom:1px solid var(--soft-mist);display:flex;justify-content:space-between;align-items:center}
    .card-title{font-size:14px;font-weight:500}
    .card-body{padding:20px}
    .card-body.no-padding{padding:0}
    .data-table{width:100%;border-collapse:collapse}
    .data-table th,.data-table td{padding:12px 16px;text-align:left;font-size:13px;border-bottom:1px solid var(--soft-mist)}
    .data-table th{font-weight:500;color:var(--text-light);font-size:11px;text-transform:uppercase;background:var(--soft-mist)}
    .data-table tr:last-child td{border-bottom:none}
    .data-table tbody tr:hover{background:rgba(255,213,217,.1)}
    .status{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:12px;font-size:11px;font-weight:500}
    .status::before{content:'';width:5px;height:5px;border-radius:50%;background:currentColor}
    .status.active{background:rgba(129,199,132,.15);color:#43A047}
    .status.pending{background:rgba(255,183,77,.15);color:#F57C00}
    .status.completed{background:rgba(100,181,246,.15);color:#1976D2}
    .status.cancelled{background:rgba(229,115,115,.15);color:#E53935}
    .status.new{background:rgba(255,140,165,.15);color:#FF8CA5}
    .user-cell{display:flex;align-items:center;gap:10px}
    .user-cell-avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--peach-glow),var(--lavender-haze));display:flex;align-items:center;justify-content:center;font-size:12px;color:var(--coral-rose)}
    .user-cell-info{}
    .user-cell-name{font-size:13px}
    .user-cell-email{font-size:11px;color:var(--text-light)}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-family:inherit;text-decoration:none;transition:all .2s ease;cursor:pointer;border:none}
    .btn-sm{padding:6px 12px;font-size:12px}
    .btn-primary{background:var(--coral-rose);color:var(--white)}
    .btn-primary:hover{background:var(--coral-rose-hover)}
    .btn-secondary{background:var(--soft-mist);color:var(--text-secondary)}
    .btn-secondary:hover{background:#e8e7e9}
    .btn-outline{background:transparent;color:var(--text-secondary);border:1px solid rgba(0,0,0,.15)}
    .btn-outline:hover{background:var(--soft-mist)}
    .btn-danger{background:transparent;color:var(--error);border:1px solid var(--error)}
    .btn-danger:hover{background:var(--error);color:white}
    .form-group{margin-bottom:16px}
    .form-label{display:block;font-size:12px;font-weight:500;color:var(--text-secondary);margin-bottom:6px}
    .form-input{width:100%;padding:10px 14px;font-size:13px;font-family:inherit;border:1px solid rgba(0,0,0,.12);border-radius:8px;background:var(--white);outline:none}
    .form-input:focus{border-color:var(--coral-rose);box-shadow:0 0 0 3px rgba(255,140,165,.1)}
    .form-select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .modal-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:none;align-items:center;justify-content:center;z-index:1000;padding:24px}
    .modal-overlay.active{display:flex}
    .modal{background:var(--white);border-radius:var(--radius-lg);width:100%;max-width:500px;max-height:90vh;overflow:hidden}
    .modal-header{padding:16px 20px;border-bottom:1px solid var(--soft-mist);display:flex;justify-content:space-between;align-items:center}
    .modal-title{font-size:16px;font-weight:500}
    .modal-close{background:none;border:none;cursor:pointer;padding:4px;color:var(--text-light);font-size:18px}
    .modal-body{padding:20px;overflow-y:auto;max-height:calc(90vh - 130px)}
    .modal-footer{padding:16px 20px;border-top:1px solid var(--soft-mist);display:flex;justify-content:flex-end;gap:8px}
    .grid-2{display:grid;grid-template-columns:2fr 1fr;gap:16px}
    .filter-bar{display:flex;align-items:center;gap:12px;padding:16px 20px;background:var(--soft-mist);border-radius:var(--radius-md) var(--radius-md) 0 0;flex-wrap:wrap}
    .filter-bar .form-input{background:var(--white);padding:8px 12px;font-size:12px}
    .pagination{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-top:1px solid var(--soft-mist)}
    .pagination-info{font-size:12px;color:var(--text-light)}
    .pagination-buttons{display:flex;gap:4px}
    .pagination-btn{width:32px;height:32px;border:1px solid rgba(0,0,0,.1);background:var(--white);border-radius:6px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:12px;text-decoration:none;color:var(--text-primary)}
    .pagination-btn.active{background:var(--coral-rose);color:white;border-color:var(--coral-rose)}
    .pagination-btn:hover:not(.active){background:var(--soft-mist)}
    .tabs{display:flex;gap:4px;border-bottom:1px solid var(--soft-mist);padding:0 20px}
    .tab{padding:12px 16px;font-size:13px;color:var(--text-secondary);background:none;border:none;cursor:pointer;position:relative;text-decoration:none}
    .tab:hover{color:var(--coral-rose)}
    .tab.active{color:var(--coral-rose)}
    .tab.active::after{content:'';position:absolute;bottom:-1px;left:0;right:0;height:2px;background:var(--coral-rose)}
    .quick-list{}
    .quick-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--soft-mist)}
    .quick-item:last-child{border-bottom:none}
    .quick-item-icon{width:36px;height:36px;border-radius:8px;background:var(--soft-mist);display:flex;align-items:center;justify-content:center;font-size:16px}
    .quick-item-content{flex:1}
    .quick-item-title{font-size:13px;margin-bottom:2px}
    .quick-item-meta{font-size:11px;color:var(--text-light)}
    .quick-item-action{font-size:12px;color:var(--coral-rose);text-decoration:none}
    .quick-item-action:hover{text-decoration:underline}
    .toast{position:fixed;top:24px;right:24px;padding:14px 20px;background:var(--white);border-radius:8px;box-shadow:0 10px 40px rgba(0,0,0,.15);transform:translateX(120%);transition:transform .3s ease;z-index:1100}
    .toast.show{transform:translateX(0)}
    .toast.success{border-left:4px solid var(--success)}
    .toast.error{border-left:4px solid var(--error)}
    .sidebar-overlay{display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);z-index:99}
    .sidebar-overlay.active{display:block}

    .alert{padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:16px;font-size:13px}
    .alert-success{background:rgba(129,199,132,.1);border:1px solid var(--success);color:#388E3C}
    .alert-error{background:rgba(229,115,115,.1);border:1px solid var(--error);color:#C62828}

    .empty-state{text-align:center;padding:48px 24px;color:var(--text-light)}
    .empty-state-icon{font-size:48px;margin-bottom:16px;opacity:.5}
    .empty-state p{font-size:14px;margin-bottom:16px}

    @media(max-width:1200px){.stats-grid{grid-template-columns:repeat(2,1fr)}.grid-2{grid-template-columns:1fr}}
    @media(max-width:1024px){.sidebar{transform:translateX(-100%)}.sidebar.active{transform:translateX(0)}.main-content{margin-left:0}.mobile-menu-btn{display:block}.search-box{display:none}}
    @media(max-width:768px){.stats-grid{grid-template-columns:1fr}.content{padding:16px}.form-row{grid-template-columns:1fr}.filter-bar{flex-direction:column;align-items:stretch}.filter-bar .form-input{width:100%!important}}
    @yield('styles')
  </style>
</head>
<body>
  @php
    $admin = Auth::user();
    $pendingInquiriesCount = \App\Models\ContactInquiry::where('status', 'new')->count();
    $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
    $totalUsers = \App\Models\User::where('role', 'user')->count();
  @endphp

  <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
  <div class="admin-layout">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-logo">FLOW<span>GRAM</span><span class="admin-badge">ADMIN</span></a>
      </div>
      <nav class="sidebar-nav">
        <div class="nav-section">
          <div class="nav-section-title">ダッシュボード</div>
          <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            概要
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">会員管理</div>
          <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            会員一覧
            <span class="badge">{{ $totalUsers }}</span>
          </a>
          <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            申込管理
            @if($pendingOrdersCount > 0)
              <span class="badge">{{ $pendingOrdersCount }}</span>
            @endif
          </a>
        </div>
        <div class="nav-section">
          <div class="nav-section-title">コンテンツ</div>
          <a href="{{ route('admin.downloads.index') }}" class="nav-item {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            資料アップロード
          </a>
          <a href="{{ route('admin.inquiries.index') }}" class="nav-item {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            問い合わせ
            @if($pendingInquiriesCount > 0)
              <span class="badge">{{ $pendingInquiriesCount }}</span>
            @endif
          </a>
        </div>
      </nav>
      <div class="sidebar-footer">
        <div class="admin-user">
          <div class="admin-avatar">{{ mb_substr($admin->name ?? '管', 0, 1) }}</div>
          <div class="admin-info">
            <div class="admin-name">{{ $admin->name ?? '管理者' }}</div>
            <div class="admin-role">Super Admin</div>
          </div>
        </div>
      </div>
    </aside>

    <main class="main-content">
      <header class="topbar">
        <div class="topbar-left">
          <button class="mobile-menu-btn" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
          <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">ホーム</a> / <span>@yield('breadcrumb', 'ダッシュボード')</span>
          </div>
        </div>
        <div class="topbar-right">
          <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" placeholder="検索...">
          </div>
          <button class="topbar-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            @if($pendingInquiriesCount > 0)
              <span class="notification-dot"></span>
            @endif
          </button>
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
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
    function openModal(id) {
      document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
      document.getElementById(id).classList.remove('active');
    }
    document.querySelectorAll('.modal-overlay').forEach(o => {
      o.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
      });
    });
    @yield('scripts')
  </script>
</body>
</html>

