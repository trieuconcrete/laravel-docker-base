@extends('flowgram.layouts.mypage')

@section('title', 'パスワード変更')
@section('page_title', 'パスワード変更')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">パスワード変更</h2>
    </div>
    <div class="section-body">
      <form id="passwordForm" action="{{ route('mypage.password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="form-label">現在のパスワード</label>
          <input type="password" name="current_password" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">新しいパスワード</label>
          <input type="password" name="password" class="form-input" required minlength="8">
          <small style="color:var(--text-light);font-size:12px;">8文字以上で入力してください</small>
        </div>
        <div class="form-group">
          <label class="form-label">新しいパスワード（確認）</label>
          <input type="password" name="password_confirmation" class="form-input" required>
        </div>
        <div style="display:flex;gap:12px;">
          <button type="submit" class="btn btn-primary">パスワードを変更</button>
          <a href="{{ route('mypage.profile') }}" class="btn btn-secondary">キャンセル</a>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const password = this.querySelector('[name="password"]').value;
    const confirmation = this.querySelector('[name="password_confirmation"]').value;
    
    if (password !== confirmation) {
      e.preventDefault();
      showToast('パスワードが一致しません', 'error');
      return;
    }
  });
@endsection

