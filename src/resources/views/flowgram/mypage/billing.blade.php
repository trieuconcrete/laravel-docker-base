@extends('flowgram.layouts.mypage')

@section('title', '請求情報')
@section('page_title', '請求情報')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">請求情報</h2>
    </div>
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
          <div class="billing-card-value" style="font-size: 18px;">
            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
          </div>
          <div class="billing-card-sub">{{ $plan?->name ?? '' }}</div>
        </div>
      </div>

      <h3 style="font-size:16px;font-weight:400;margin-bottom:16px;">支払い履歴</h3>
      @if($payments->count() > 0)
        <table class="data-table">
          <thead>
            <tr>
              <th>請求日</th>
              <th>請求番号</th>
              <th>内容</th>
              <th>金額</th>
              <th>状態</th>
            </tr>
          </thead>
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

        @if($payments->hasPages())
          <div class="pagination">
            {{ $payments->links() }}
          </div>
        @endif
      @else
        <div class="no-data">
          <div class="no-data-icon">💳</div>
          <p>支払い履歴はありません</p>
        </div>
      @endif
    </div>
  </div>

  @if($subscription && $subscription->status === 'active')
    <div class="section">
      <div class="section-header">
        <h2 class="section-title">解約申請</h2>
      </div>
      <div class="section-body">
        <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">
          サービスを解約される場合は、下記より解約申請を行ってください。<br>
          現在の契約期間終了日（{{ $subscription->expires_at?->format('Y年n月j日') ?? '未定' }}）まではサービスをご利用いただけます。
        </p>
        <a href="{{ route('mypage.cancel') }}" class="btn btn-secondary" style="border-color:var(--warning);color:var(--warning);">解約を申請する</a>
      </div>
    </div>
  @endif
@endsection

