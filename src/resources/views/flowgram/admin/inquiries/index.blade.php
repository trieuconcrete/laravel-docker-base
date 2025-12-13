@extends('flowgram.layouts.admin')

@section('title', '問い合わせ管理')
@section('breadcrumb', '問い合わせ管理')

@section('content')
  <div class="page-header">
    <h1 class="page-title">問い合わせ管理</h1>
    <p class="page-subtitle">会員からの問い合わせ一覧</p>
  </div>

  <div class="card">
    <div class="tabs">
      <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}" class="tab {{ request('status', 'new') == 'new' ? 'active' : '' }}">未対応 ({{ $counts['new'] ?? 0 }})</a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'in_progress']) }}" class="tab {{ request('status') == 'in_progress' ? 'active' : '' }}">対応中 ({{ $counts['in_progress'] ?? 0 }})</a>
      <a href="{{ route('admin.inquiries.index', ['status' => 'resolved']) }}" class="tab {{ request('status') == 'resolved' ? 'active' : '' }}">完了 ({{ $counts['resolved'] ?? 0 }})</a>
    </div>

    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>受付日</th>
            <th>会員</th>
            <th>カテゴリ</th>
            <th>件名</th>
            <th>状態</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @forelse($inquiries as $inquiry)
            <tr>
              <td>{{ $inquiry->created_at->format('Y/m/d H:i') }}</td>
              <td>
                <div class="user-cell">
                  <div class="user-cell-avatar">{{ mb_substr($inquiry->name, 0, 1) }}</div>
                  <div class="user-cell-name">{{ $inquiry->name }}</div>
                </div>
              </td>
              <td>
                @if(is_array($inquiry->topics))
                  {{ implode(', ', array_map(fn($t) => match($t) {
                    'sns' => 'SNS運用',
                    'review' => '動画添削',
                    'edit' => '動画編集',
                    'counseling' => 'カウンセリング',
                    'subscription' => 'サブスク',
                    'payment' => 'お支払い',
                    default => 'その他'
                  }, $inquiry->topics)) }}
                @else
                  その他
                @endif
              </td>
              <td>{{ $inquiry->subject }}</td>
              <td>
                <span class="status {{ $inquiry->status }}">
                  @switch($inquiry->status)
                    @case('new') 未対応 @break
                    @case('in_progress') 対応中 @break
                    @case('resolved') 完了 @break
                  @endswitch
                </span>
              </td>
              <td>
                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary">対応</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center;padding:32px;color:var(--text-light);">問い合わせがありません</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($inquiries->hasPages())
      <div class="pagination">
        <div class="pagination-info">{{ $inquiries->firstItem() }}-{{ $inquiries->lastItem() }} / {{ $inquiries->total() }}件</div>
        <div class="pagination-buttons">
          @if($inquiries->onFirstPage())
            <span class="pagination-btn" style="opacity:0.5;">←</span>
          @else
            <a href="{{ $inquiries->previousPageUrl() }}" class="pagination-btn">←</a>
          @endif

          @foreach($inquiries->getUrlRange(max(1, $inquiries->currentPage() - 2), min($inquiries->lastPage(), $inquiries->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="pagination-btn {{ $page == $inquiries->currentPage() ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($inquiries->hasMorePages())
            <a href="{{ $inquiries->nextPageUrl() }}" class="pagination-btn">→</a>
          @else
            <span class="pagination-btn" style="opacity:0.5;">→</span>
          @endif
        </div>
      </div>
    @endif
  </div>
@endsection

