@extends('flowgram.layouts.mypage')

@section('title', 'ダッシュボード')
@section('page_title', 'ダッシュボード')

@section('content')
  <div class="dashboard-grid">
    <div class="stat-card">
      <div class="stat-icon peach">📊</div>
      <div class="stat-value">{{ $orders->count() }}</div>
      <div class="stat-label">申込件数</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon lavender">💰</div>
      <div class="stat-value">¥{{ number_format($currentMonthPayments) }}</div>
      <div class="stat-label">今月の請求額</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon mint">📁</div>
      <div class="stat-value">{{ $downloads->count() }}</div>
      <div class="stat-label">ダウンロード資料</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon sky">📅</div>
      <div class="stat-value">{{ $nextBillingDate ? $nextBillingDate->diffInDays(now()) : '-' }}日</div>
      <div class="stat-label">次回更新まで</div>
    </div>
  </div>

  <div class="section">
    <div class="section-header">
      <h2 class="section-title">現在のプラン</h2>
      <a href="#" class="section-action">プラン変更</a>
    </div>
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
        <a href="https://line.me" target="_blank" class="quick-action">
          <div class="quick-action-icon">💬</div>
          <span>LINEで相談</span>
        </a>
        <a href="#" class="quick-action">
          <div class="quick-action-icon">🎬</div>
          <span>動画添削を依頼</span>
        </a>
        <a href="#" class="quick-action">
          <div class="quick-action-icon">📞</div>
          <span>カウンセリング予約</span>
        </a>
      </div>
    </div>
  </div>

  <div class="grid-2">
    <div class="section">
      <div class="section-header">
        <h2 class="section-title">最近の申込</h2>
        <a href="{{ route('mypage.orders') }}" class="section-action">すべて見る</a>
      </div>
      <div class="section-body">
        @if($orders->count() > 0)
          <table class="data-table">
            <thead>
              <tr><th>日付</th><th>内容</th><th>金額</th><th>状態</th></tr>
            </thead>
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
      <div class="section-header">
        <h2 class="section-title">ダウンロード資料</h2>
        <a href="{{ route('mypage.downloads') }}" class="section-action">すべて見る</a>
      </div>
      <div class="section-body">
        @if($downloads->count() > 0)
          <div class="download-list">
            @foreach($downloads->take(2) as $download)
              <div class="download-item">
                <div class="download-icon">
                  {{ $download->category === 'report' ? '📊' : ($download->category === 'deliverable' ? '🎬' : '📄') }}
                </div>
                <div class="download-info">
                  <h5>{{ $download->title }}</h5>
                  <p>{{ strtoupper($download->file_type) }} • {{ $download->formatted_size }}</p>
                </div>
                <a href="{{ route('mypage.download', $download) }}" class="download-btn">ダウンロード</a>
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
@endsection

