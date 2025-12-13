@extends('flowgram.layouts.mypage')

@section('title', '解約申請')
@section('page_title', '解約申請')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">解約申請</h2>
    </div>
    <div class="section-body">
      @if($subscription && $subscription->status === 'active')
        <div class="plan-card" style="margin-bottom:24px;">
          <div class="plan-info">
            <h4>現在のプラン: {{ $plan?->name ?? '未登録' }}</h4>
            <p>契約期間終了日: {{ $subscription->expires_at?->format('Y年n月j日') ?? '未定' }}</p>
            <span class="status-badge active">提供中</span>
          </div>
          <div class="plan-price">
            <div class="amount">¥{{ number_format($plan?->price ?? 0) }}</div>
            <div class="period">/月</div>
          </div>
        </div>

        <div style="background:rgba(255,183,77,0.1);border:1px solid var(--warning);border-radius:var(--radius-md);padding:16px;margin-bottom:24px;">
          <p style="font-size:14px;color:#F57C00;margin:0;">
            <strong>ご注意：</strong> 解約申請後も契約期間終了日までサービスをご利用いただけます。<br>
            契約期間終了後、自動更新は停止されます。
          </p>
        </div>

        <form action="{{ route('mypage.cancel.submit') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="form-label">解約理由をお聞かせください（任意）</label>
            <textarea name="cancel_reason" class="form-input" placeholder="ご意見・ご要望をお聞かせください。サービス改善の参考にさせていただきます。"></textarea>
          </div>
          <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-danger">解約を申請する</button>
            <a href="{{ route('mypage.billing') }}" class="btn btn-secondary">キャンセル</a>
          </div>
        </form>
      @else
        <div class="no-data">
          <div class="no-data-icon">⚠️</div>
          <p>アクティブなサブスクリプションがありません</p>
          <a href="{{ route('mypage.billing') }}" class="btn btn-primary">請求情報に戻る</a>
        </div>
      @endif
    </div>
  </div>
@endsection

