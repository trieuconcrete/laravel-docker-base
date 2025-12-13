@extends('flowgram.layouts.admin')

@section('title', '会員一覧')
@section('breadcrumb', '会員一覧')

@section('content')
  <div class="page-header flex">
    <div>
      <h1 class="page-title">会員一覧</h1>
      <p class="page-subtitle">登録会員の管理</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('userModal')">+ 新規追加</button>
  </div>

  <div class="card">
    <form method="GET" action="{{ route('admin.users.index') }}" class="filter-bar">
      <input type="text" name="search" class="form-input" placeholder="名前・メールで検索..." style="width:240px;" value="{{ request('search') }}">
      <select name="plan" class="form-input form-select" style="width:150px;">
        <option value="">すべてのプラン</option>
        @foreach($plans as $plan)
          <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
        @endforeach
      </select>
      <select name="status" class="form-input form-select" style="width:140px;">
        <option value="">すべての状態</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>提供中</option>
        <option value="cancelling" {{ request('status') == 'cancelling' ? 'selected' : '' }}>解約申請中</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>解約済</option>
        <option value="none" {{ request('status') == 'none' ? 'selected' : '' }}>未登録</option>
      </select>
      <button type="submit" class="btn btn-secondary btn-sm">検索</button>
    </form>

    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>会員</th>
            <th>プラン</th>
            <th>登録日</th>
            <th>状態</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            @php
              $subscription = $user->subscriptions()->latest()->first();
              $plan = $subscription?->plan;
              $status = $subscription?->status ?? 'none';
              $statusLabel = match($status) {
                'active' => '提供中', 'pending' => '受付済', 'confirmed' => '決済確認済',
                'cancelling' => '解約申請中', 'cancelled' => '解約済', 'expired' => '期限切れ',
                default => '未登録'
              };
            @endphp
            <tr>
              <td>
                <div class="user-cell">
                  <div class="user-cell-avatar">{{ mb_substr($user->name, 0, 1) }}</div>
                  <div class="user-cell-info">
                    <div class="user-cell-name">{{ $user->name }}</div>
                    <div class="user-cell-email">{{ $user->email }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $plan?->name ?? '未登録' }}</td>
              <td>{{ $user->created_at->format('Y/m/d') }}</td>
              <td><span class="status {{ $status }}">{{ $statusLabel }}</span></td>
              <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-secondary">編集</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center;padding:32px;color:var(--text-light);">会員が見つかりませんでした</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($users->hasPages())
      <div class="pagination">
        <div class="pagination-info">{{ $users->firstItem() }}-{{ $users->lastItem() }} / {{ $users->total() }}件</div>
        <div class="pagination-buttons">
          @if($users->onFirstPage())
            <span class="pagination-btn" style="opacity:0.5;">←</span>
          @else
            <a href="{{ $users->previousPageUrl() }}" class="pagination-btn">←</a>
          @endif

          @foreach($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="pagination-btn {{ $page == $users->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="pagination-btn">→</a>
          @else
            <span class="pagination-btn" style="opacity:0.5;">→</span>
          @endif
        </div>
      </div>
    @endif
  </div>

  <!-- User Modal -->
  <div class="modal-overlay" id="userModal">
    <div class="modal">
      <div class="modal-header">
        <h3 class="modal-title">会員情報編集</h3>
        <button class="modal-close" onclick="closeModal('userModal')">✕</button>
      </div>
      <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
        @csrf
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">お名前</label>
              <input type="text" name="name" class="form-input" required>
            </div>
            <div class="form-group">
              <label class="form-label">電話番号</label>
              <input type="tel" name="phone" class="form-input">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">パスワード</label>
            <input type="password" name="password" class="form-input" minlength="8">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">プラン</label>
              <select name="plan_id" class="form-input form-select">
                <option value="">プランなし</option>
                @foreach($plans as $plan)
                  <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">ステータス</label>
              <select name="subscription_status" class="form-input form-select">
                <option value="active">提供中</option>
                <option value="pending">受付済</option>
                <option value="confirmed">決済確認済</option>
                <option value="cancelling">解約申請中</option>
                <option value="cancelled">解約済</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal('userModal')">キャンセル</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>
    </div>
  </div>
@endsection

