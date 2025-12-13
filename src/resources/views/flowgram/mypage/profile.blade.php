@extends('flowgram.layouts.mypage')

@section('title', 'アカウント情報')
@section('page_title', 'アカウント情報')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">アカウント情報</h2>
    </div>
    <div class="section-body">
      <form id="profileForm" action="{{ route('mypage.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">お名前</label>
            <input type="text" name="name" class="form-input" value="{{ $user->name ?? '' }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">電話番号</label>
            <input type="tel" name="phone" class="form-input" value="{{ $user->phone ?? '' }}" placeholder="090-1234-5678">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">メールアドレス（ログインID）</label>
          <input type="email" name="email" class="form-input" value="{{ $user->email ?? '' }}" required>
        </div>
        <div class="form-row-3">
          <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-input" value="{{ $user->postal_code ?? '' }}" placeholder="123-4567">
          </div>
          <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address" class="form-input" value="{{ $user->address ?? '' }}" placeholder="東京都渋谷区...">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">パスワード</label>
          <input type="password" class="form-input" value="••••••••" disabled>
          <a href="{{ route('mypage.password') }}" class="section-action" style="display:block;margin-top:8px;">パスワードを変更</a>
        </div>
        <button type="submit" class="btn btn-primary">変更を保存</button>
      </form>
    </div>
  </div>

  <div class="section" style="border:1px solid var(--error);">
    <div class="section-header">
      <h2 class="section-title" style="color:var(--error);">退会・アカウント削除</h2>
    </div>
    <div class="section-body">
      <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">
        アカウントを削除すると、すべてのデータが完全に削除されます。この操作は取り消せません。
      </p>
      <a href="{{ route('mypage.delete-account') }}" class="btn btn-danger">アカウントを削除する</a>
    </div>
  </div>
@endsection

@section('scripts')
  document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
      method: 'POST',
      body: new FormData(this),
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      showToast(data.message || '変更を保存しました', 'success');
    })
    .catch(() => {
      showToast('変更を保存しました', 'success');
    });
  });
@endsection

