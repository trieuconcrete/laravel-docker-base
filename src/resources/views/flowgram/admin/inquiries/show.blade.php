@extends('flowgram.layouts.admin')

@section('title', '問い合わせ詳細')
@section('breadcrumb', '問い合わせ管理 / 詳細')

@section('content')
  <div class="page-header flex">
    <div>
      <h1 class="page-title">問い合わせ詳細</h1>
      <p class="page-subtitle">{{ $inquiry->subject }}</p>
    </div>
    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">← 一覧に戻る</a>
  </div>

  <div class="grid-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">問い合わせ内容</h3>
        <span class="status {{ $inquiry->status }}">
          @switch($inquiry->status)
            @case('new') 未対応 @break
            @case('in_progress') 対応中 @break
            @case('resolved') 完了 @break
          @endswitch
        </span>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="form-label">受付日時</label>
          <div>{{ $inquiry->created_at->format('Y年m月d日 H:i') }}</div>
        </div>
        <div class="form-group">
          <label class="form-label">件名</label>
          <div style="font-size:16px;font-weight:500;">{{ $inquiry->subject }}</div>
        </div>
        <div class="form-group">
          <label class="form-label">カテゴリ</label>
          <div>
            @if(is_array($inquiry->topics))
              @foreach($inquiry->topics as $topic)
                <span style="display:inline-block;background:var(--soft-mist);padding:4px 12px;border-radius:12px;font-size:12px;margin-right:4px;">
                  @switch($topic)
                    @case('sns') SNS運用サポート @break
                    @case('review') 動画添削 @break
                    @case('edit') 動画編集 @break
                    @case('counseling') 個別カウンセリング @break
                    @case('subscription') サブスクリプション @break
                    @case('payment') お支払い @break
                    @default その他
                  @endswitch
                </span>
              @endforeach
            @endif
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">内容</label>
          <div style="background:var(--soft-mist);padding:16px;border-radius:8px;white-space:pre-wrap;">{{ $inquiry->message }}</div>
        </div>
      </div>
    </div>

    <div>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">送信者情報</h3>
        </div>
        <div class="card-body">
          <div class="user-cell" style="margin-bottom:16px;">
            <div class="user-cell-avatar" style="width:48px;height:48px;font-size:18px;">{{ mb_substr($inquiry->name, 0, 1) }}</div>
            <div class="user-cell-info">
              <div class="user-cell-name" style="font-size:16px;">{{ $inquiry->name }}</div>
              <div class="user-cell-email">{{ $inquiry->email }}</div>
            </div>
          </div>
          @if($inquiry->phone)
            <div class="form-group">
              <label class="form-label">電話番号</label>
              <div>{{ $inquiry->phone }}</div>
            </div>
          @endif
          @if($inquiry->user)
            <div class="form-group">
              <label class="form-label">会員情報</label>
              <a href="{{ route('admin.users.edit', $inquiry->user) }}" class="btn btn-sm btn-outline">会員ページを開く</a>
            </div>
          @endif
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">ステータス更新</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label class="form-label">ステータス</label>
              <select name="status" class="form-input form-select">
                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>未対応</option>
                <option value="in_progress" {{ $inquiry->status == 'in_progress' ? 'selected' : '' }}>対応中</option>
                <option value="resolved" {{ $inquiry->status == 'resolved' ? 'selected' : '' }}>完了</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">対応メモ（管理者用）</label>
              <textarea name="admin_notes" class="form-input" rows="4" placeholder="対応内容をメモ...">{{ $inquiry->admin_notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">クイックアクション</h3>
        </div>
        <div class="card-body">
          <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ $inquiry->subject }}" class="btn btn-outline" style="width:100%;margin-bottom:8px;">📧 メールで返信</a>
          <a href="https://line.me" target="_blank" class="btn btn-outline" style="width:100%;">💬 LINEで返信</a>
        </div>
      </div>
    </div>
  </div>
@endsection

