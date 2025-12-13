@extends('flowgram.layouts.mypage')

@section('title', '申込履歴')
@section('page_title', '申込履歴')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">申込履歴</h2>
    </div>
    <div class="section-body">
      @if($orders->count() > 0)
        <table class="data-table">
          <thead>
            <tr>
              <th>申込日</th>
              <th>注文番号</th>
              <th>プラン・サービス名</th>
              <th>決済金額</th>
              <th>決済方法</th>
              <th>ステータス</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td>{{ $order->created_at->format('Y/m/d') }}</td>
                <td><small>{{ $order->order_number }}</small></td>
                <td>{{ $order->item_name }}</td>
                <td>{{ $order->formatted_total }}</td>
                <td>
                  @switch($order->payment_method)
                    @case('credit_card') クレジットカード @break
                    @case('bank_transfer') 銀行振込 @break
                    @default その他
                  @endswitch
                </td>
                <td><span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>

        @if($orders->hasPages())
          <div class="pagination">
            {{ $orders->links() }}
          </div>
        @endif
      @else
        <div class="no-data">
          <div class="no-data-icon">📋</div>
          <p>申込履歴はありません</p>
          <a href="{{ url('/') }}#pricing" class="btn btn-primary">プランを見る</a>
        </div>
      @endif
    </div>
  </div>
@endsection

