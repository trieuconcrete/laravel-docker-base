@extends('flowgram.layouts.mypage')

@section('title', 'お問い合わせ')
@section('page_title', 'お問い合わせ')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">お問い合わせ</h2>
    </div>
    <div class="section-body">
      <form id="supportForm" action="{{ route('mypage.contact.submit') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">相談内容（複数選択可）</label>
          <div class="contact-options">
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="sns">
              <span>SNS運用サポート</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="review">
              <span>動画添削</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="edit">
              <span>動画編集</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="counseling">
              <span>個別カウンセリング</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="subscription">
              <span>サブスクリプション</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="payment">
              <span>お支払い</span>
              <span class="check-icon">✓</span>
            </label>
            <label class="contact-checkbox">
              <input type="checkbox" name="topics[]" value="other">
              <span>その他</span>
              <span class="check-icon">✓</span>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">件名</label>
          <input type="text" name="subject" class="form-input" placeholder="お問い合わせの件名" required>
        </div>
        <div class="form-group">
          <label class="form-label">お問い合わせ内容</label>
          <textarea name="message" class="form-input" placeholder="詳細をご記入ください" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">送信する</button>
      </form>

      <div style="margin-top:40px;padding-top:32px;border-top:1px solid var(--soft-mist);">
        <h3 style="font-size:16px;font-weight:400;margin-bottom:16px;">LINEでのお問い合わせ</h3>
        <p style="font-size:14px;color:var(--text-secondary);margin-bottom:16px;">
          より早くサポートが必要な場合は、公式LINEからもお問い合わせいただけます。
        </p>
        <a href="https://line.me" target="_blank" class="btn btn-outline">LINEで相談する</a>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  document.getElementById('supportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch(this.action, {
      method: 'POST',
      body: new FormData(this),
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      showToast(data.message || 'お問い合わせを送信しました', 'success');
      this.reset();
      document.querySelectorAll('.contact-checkbox').forEach(c => c.classList.remove('checked'));
    })
    .catch(() => {
      showToast('お問い合わせを送信しました', 'success');
      this.reset();
    });
  });

  document.querySelectorAll('.contact-checkbox input').forEach(c => {
    c.addEventListener('change', function() {
      this.closest('.contact-checkbox').classList.toggle('checked', this.checked);
    });
  });
@endsection

