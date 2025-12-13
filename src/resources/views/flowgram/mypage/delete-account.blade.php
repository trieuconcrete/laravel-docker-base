@extends('flowgram.layouts.mypage')

@section('title', 'アカウント削除')
@section('page_title', 'アカウント削除')

@section('content')
  <div class="section" style="border:1px solid var(--error);">
    <div class="section-header">
      <h2 class="section-title" style="color:var(--error);">アカウント削除の確認</h2>
    </div>
    <div class="section-body">
      <div style="background:rgba(229,115,115,0.1);border:1px solid var(--error);border-radius:var(--radius-md);padding:16px;margin-bottom:24px;">
        <p style="font-size:14px;color:#C62828;margin:0;">
          <strong>⚠️ 警告：</strong> この操作は取り消せません。<br>
          アカウントを削除すると、以下のデータがすべて完全に削除されます：
        </p>
        <ul style="font-size:14px;color:#C62828;margin:12px 0 0 20px;">
          <li>アカウント情報（名前、メール、住所など）</li>
          <li>申込履歴・支払い履歴</li>
          <li>ダウンロード資料へのアクセス権</li>
          <li>お問い合わせ履歴</li>
        </ul>
      </div>

      @if($subscription && in_array($subscription->status, ['active', 'pending', 'confirmed']))
        <div style="background:rgba(255,183,77,0.1);border:1px solid var(--warning);border-radius:var(--radius-md);padding:16px;margin-bottom:24px;">
          <p style="font-size:14px;color:#F57C00;margin:0;">
            <strong>ご注意：</strong> 現在アクティブなサブスクリプションがあります。<br>
            アカウントを削除する前に、先にサブスクリプションを解約してください。
          </p>
        </div>
        <a href="{{ route('mypage.cancel') }}" class="btn btn-secondary" style="border-color:var(--warning);color:var(--warning);">先に解約申請を行う</a>
      @else
        <form action="{{ route('mypage.delete-account.submit') }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="form-group">
            <label class="form-label">確認のため、パスワードを入力してください</label>
            <input type="password" name="password" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="contact-checkbox" style="background:transparent;padding:0;">
              <input type="checkbox" name="confirm" required>
              <span style="color:var(--text-secondary);">上記の内容を理解し、アカウントを削除することに同意します</span>
              <span class="check-icon">✓</span>
            </label>
          </div>
          <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-danger">アカウントを完全に削除</button>
            <a href="{{ route('mypage.profile') }}" class="btn btn-secondary">キャンセル</a>
          </div>
        </form>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  document.querySelectorAll('.contact-checkbox input').forEach(c => {
    c.addEventListener('change', function() {
      this.closest('.contact-checkbox').classList.toggle('checked', this.checked);
    });
  });
@endsection

