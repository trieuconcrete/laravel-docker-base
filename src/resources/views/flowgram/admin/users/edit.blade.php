@extends('flowgram.layouts.admin')

@section('title', '会員編集')
@section('breadcrumb', '会員一覧 / 編集')

@section('content')
  <div class="page-header">
    <h1 class="page-title">会員情報編集</h1>
    <p class="page-subtitle">{{ $user->name }} さんの情報</p>
  </div>

  @php
    $subscription = $user->subscriptions()->latest()->first();
    $plan = $subscription?->plan;
  @endphp

  <div class="grid-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">基本情報</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
          @csrf
          @method('PUT')
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">お名前</label>
              <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">電話番号</label>
              <input type="tel" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">郵便番号</label>
              <input type="text" name="postal_code" class="form-input" value="{{ old('postal_code', $user->postal_code) }}">
            </div>
            <div class="form-group">
              <label class="form-label">住所</label>
              <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">新しいパスワード（変更する場合のみ）</label>
            <input type="password" name="password" class="form-input" minlength="8">
          </div>
          <div style="display:flex;gap:8px;">
            <button type="submit" class="btn btn-primary">保存</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">キャンセル</a>
          </div>
        </form>
      </div>
    </div>

    <div>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">サブスクリプション</h3>
        </div>
        <div class="card-body">
          @if($subscription)
            <div class="form-group">
              <label class="form-label">現在のプラン</label>
              <div style="font-size:16px;font-weight:500;">{{ $plan?->name ?? '未登録' }}</div>
            </div>
            <div class="form-group">
              <label class="form-label">ステータス</label>
              <span class="status {{ $subscription->status }}">
                @switch($subscription->status)
                  @case('active') 提供中 @break
                  @case('pending') 受付済 @break
                  @case('confirmed') 決済確認済 @break
                  @case('cancelling') 解約申請中 @break
                  @case('cancelled') 解約済 @break
                  @case('expired') 期限切れ @break
                @endswitch
              </span>
            </div>
            <div class="form-group">
              <label class="form-label">契約開始日</label>
              <div>{{ $subscription->starts_at?->format('Y/m/d') ?? '-' }}</div>
            </div>
            <div class="form-group">
              <label class="form-label">次回更新日</label>
              <div>{{ $subscription->expires_at?->format('Y/m/d') ?? '-' }}</div>
            </div>
            <form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}" style="margin-top:16px;">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">プラン変更</label>
                  <select name="plan_id" class="form-input form-select">
                    @foreach($plans as $p)
                      <option value="{{ $p->id }}" {{ $plan?->id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">ステータス変更</label>
                  <select name="status" class="form-input form-select">
                    <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>提供中</option>
                    <option value="pending" {{ $subscription->status == 'pending' ? 'selected' : '' }}>受付済</option>
                    <option value="confirmed" {{ $subscription->status == 'confirmed' ? 'selected' : '' }}>決済確認済</option>
                    <option value="cancelling" {{ $subscription->status == 'cancelling' ? 'selected' : '' }}>解約申請中</option>
                    <option value="cancelled" {{ $subscription->status == 'cancelled' ? 'selected' : '' }}>解約済</option>
                    <option value="expired" {{ $subscription->status == 'expired' ? 'selected' : '' }}>期限切れ</option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">更新</button>
            </form>
          @else
            <div class="empty-state">
              <p>サブスクリプションがありません</p>
            </div>
            <form method="POST" action="{{ route('admin.subscriptions.store') }}">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">プラン</label>
                  <select name="plan_id" class="form-input form-select" required>
                    @foreach($plans as $p)
                      <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">ステータス</label>
                  <select name="status" class="form-input form-select">
                    <option value="active">提供中</option>
                    <option value="pending">受付済</option>
                    <option value="confirmed">決済確認済</option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm">サブスク追加</button>
            </form>
          @endif
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">最近の申込</h3>
        </div>
        <div class="card-body no-padding">
          @if($user->orders->count() > 0)
            <table class="data-table">
              <thead>
                <tr><th>日付</th><th>内容</th><th>金額</th></tr>
              </thead>
              <tbody>
                @foreach($user->orders()->latest()->take(5)->get() as $order)
                  <tr>
                    <td>{{ $order->created_at->format('Y/m/d') }}</td>
                    <td>{{ $order->item_name }}</td>
                    <td>{{ $order->formatted_total }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="empty-state"><p>申込履歴がありません</p></div>
          @endif
        </div>
      </div>

      <div class="card" style="border:1px solid var(--error);">
        <div class="card-header">
          <h3 class="card-title" style="color:var(--error);">危険な操作</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('本当にこの会員を削除しますか？この操作は取り消せません。')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">会員を削除</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

