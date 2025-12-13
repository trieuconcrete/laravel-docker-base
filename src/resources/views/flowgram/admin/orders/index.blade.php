@extends('flowgram.layouts.admin')

@section('title', '申込管理')
@section('breadcrumb', '申込管理')

@section('content')
  <div class="page-header">
    <h1 class="page-title">申込管理</h1>
    <p class="page-subtitle">申込・決済情報の管理（手動更新）</p>
  </div>

  <div class="card">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-bar">
      <input type="text" name="search" class="form-input" placeholder="会員名・内容で検索..." style="width:240px;" value="{{ request('search') }}">
      <select name="status" class="form-input form-select" style="width:150px;">
        <option value="">すべての状態</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>受付済</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>決済確認済</option>
        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>制作中</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>完了</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>キャンセル</option>
      </select>
      <select name="type" class="form-input form-select" style="width:150px;">
        <option value="">すべての種類</option>
        <option value="subscription" {{ request('type') == 'subscription' ? 'selected' : '' }}>サブスク</option>
        <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>単発サービス</option>
        <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>商品</option>
      </select>
      <button type="submit" class="btn btn-secondary btn-sm">検索</button>
    </form>

    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>申込日</th>
            <th>会員</th>
            <th>内容</th>
            <th>金額</th>
            <th>決済方法</th>
            <th>状態</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            <tr>
              <td>{{ $order->created_at->format('Y/m/d') }}</td>
              <td>
                <div class="user-cell">
                  <div class="user-cell-avatar">{{ mb_substr($order->user->name ?? 'U', 0, 1) }}</div>
                  <div class="user-cell-name">{{ $order->user->name ?? '不明' }}</div>
                </div>
              </td>
              <td>{{ $order->item_name }}</td>
              <td>{{ $order->formatted_total }}</td>
              <td>
                @switch($order->payment_method)
                  @case('credit_card') クレジット @break
                  @case('bank_transfer') 銀行振込 @break
                  @default その他
                @endswitch
              </td>
              <td><span class="status {{ $order->status }}">{{ $order->status_label }}</span></td>
              <td>
                <button class="btn btn-sm btn-secondary" onclick="openOrderModal({{ json_encode($order) }})">編集</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align:center;padding:32px;color:var(--text-light);">申込が見つかりませんでした</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="pagination">
        <div class="pagination-info">{{ $orders->firstItem() }}-{{ $orders->lastItem() }} / {{ $orders->total() }}件</div>
        <div class="pagination-buttons">
          @if($orders->onFirstPage())
            <span class="pagination-btn" style="opacity:0.5;">←</span>
          @else
            <a href="{{ $orders->previousPageUrl() }}" class="pagination-btn">←</a>
          @endif

          @foreach($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="pagination-btn {{ $page == $orders->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}" class="pagination-btn">→</a>
          @else
            <span class="pagination-btn" style="opacity:0.5;">→</span>
          @endif
        </div>
      </div>
    @endif
  </div>

  <!-- Order Modal -->
  <div class="modal-overlay" id="orderModal">
    <div class="modal">
      <div class="modal-header">
        <h3 class="modal-title">申込情報編集</h3>
        <button class="modal-close" onclick="closeModal('orderModal')">✕</button>
      </div>
      <form method="POST" id="orderForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">会員名</label>
            <input type="text" id="orderUserName" class="form-input" readonly>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">申込日</label>
              <input type="date" name="created_at" id="orderDate" class="form-input">
            </div>
            <div class="form-group">
              <label class="form-label">金額</label>
              <input type="number" name="total_amount" id="orderAmount" class="form-input">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">内容</label>
            <input type="text" name="item_name" id="orderItemName" class="form-input">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">決済方法</label>
              <select name="payment_method" id="orderPaymentMethod" class="form-input form-select">
                <option value="credit_card">クレジットカード</option>
                <option value="bank_transfer">銀行振込</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">ステータス</label>
              <select name="status" id="orderStatus" class="form-input form-select">
                <option value="pending">受付済</option>
                <option value="confirmed">決済確認済</option>
                <option value="processing">制作中</option>
                <option value="completed">完了</option>
                <option value="cancelled">キャンセル</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal('orderModal')">キャンセル</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  function openOrderModal(order) {
    const form = document.getElementById('orderForm');
    form.action = '{{ route('admin.orders.index') }}/' + order.id;
    document.getElementById('orderUserName').value = order.user?.name || '不明';
    document.getElementById('orderDate').value = order.created_at?.split('T')[0] || '';
    document.getElementById('orderAmount').value = order.total_amount;
    document.getElementById('orderItemName').value = order.item_name;
    document.getElementById('orderPaymentMethod').value = order.payment_method || 'credit_card';
    document.getElementById('orderStatus').value = order.status;
    openModal('orderModal');
  }
@endsection

