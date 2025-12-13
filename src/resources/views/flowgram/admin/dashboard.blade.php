@extends('flowgram.layouts.admin')

@section('title', 'ダッシュボード')
@section('breadcrumb', 'ダッシュボード')

@section('content')
  <div class="page-header">
    <h1 class="page-title">ダッシュボード</h1>
    <p class="page-subtitle">FLOWGRAMの概要</p>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon rose">👥</div>
      <div class="stat-content">
        <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
        <div class="stat-label">総会員数</div>
        <div class="stat-change up">↑ {{ $stats['users_growth'] }}%</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue">💳</div>
      <div class="stat-content">
        <div class="stat-value">¥{{ number_format($stats['monthly_revenue']) }}</div>
        <div class="stat-label">今月の売上</div>
        <div class="stat-change {{ $stats['revenue_growth'] >= 0 ? 'up' : 'down' }}">{{ $stats['revenue_growth'] >= 0 ? '↑' : '↓' }} {{ abs($stats['revenue_growth']) }}%</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">📝</div>
      <div class="stat-content">
        <div class="stat-value">{{ $stats['monthly_orders'] }}</div>
        <div class="stat-label">今月の申込</div>
        <div class="stat-change up">↑ {{ $stats['orders_growth'] }}%</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon orange">💬</div>
      <div class="stat-content">
        <div class="stat-value">{{ $stats['pending_inquiries'] }}</div>
        <div class="stat-label">未対応問い合わせ</div>
        @if($stats['pending_inquiries'] > 0)
          <div class="stat-change down">要対応</div>
        @else
          <div class="stat-change up">対応完了</div>
        @endif
      </div>
    </div>
  </div>

  <div class="grid-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">最近の申込</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline">すべて見る</a>
      </div>
      <div class="card-body no-padding">
        @if($recentOrders->count() > 0)
          <table class="data-table">
            <thead>
              <tr><th>会員</th><th>内容</th><th>金額</th><th>状態</th></tr>
            </thead>
            <tbody>
              @foreach($recentOrders as $order)
                <tr>
                  <td>
                    <div class="user-cell">
                      <div class="user-cell-avatar">{{ mb_substr($order->user->name ?? 'U', 0, 1) }}</div>
                      <div class="user-cell-name">{{ $order->user->name ?? '不明' }}</div>
                    </div>
                  </td>
                  <td>{{ $order->item_name }}</td>
                  <td>{{ $order->formatted_total }}</td>
                  <td><span class="status {{ $order->status }}">{{ $order->status_label }}</span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty-state">
            <p>申込がありません</p>
          </div>
        @endif
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">未対応の問い合わせ</h3>
      </div>
      <div class="card-body">
        @if($pendingInquiries->count() > 0)
          <div class="quick-list">
            @foreach($pendingInquiries as $inquiry)
              <div class="quick-item">
                <div class="quick-item-icon">💬</div>
                <div class="quick-item-content">
                  <div class="quick-item-title">{{ $inquiry->subject }}</div>
                  <div class="quick-item-meta">{{ $inquiry->name }} • {{ $inquiry->created_at->diffForHumans() }}</div>
                </div>
                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="quick-item-action">対応</a>
              </div>
            @endforeach
          </div>
        @else
          <div class="empty-state">
            <div class="empty-state-icon">✅</div>
            <p>未対応の問い合わせはありません</p>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

