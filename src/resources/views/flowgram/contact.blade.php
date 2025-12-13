<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>お問い合わせ | FLOWGRAM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Noto+Sans+JP:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --peach-glow: #FFD5D9;
      --blush-pink: #F8E7EF;
      --lavender-haze: #EEE7FF;
      --soft-mist: #F5F4F6;
      --white: #FFFFFF;
      --coral-rose: #FF8CA5;
      --coral-rose-hover: #FF7A96;
      --text-primary: #2F2F2F;
      --text-secondary: #666666;
      --text-light: #888888;
      --error: #E57373;
      --success: #81C784;
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Noto Sans JP', sans-serif;
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.8;
      background: linear-gradient(135deg, var(--white) 0%, var(--blush-pink) 50%, var(--lavender-haze) 100%);
      min-height: 100vh;
    }

    .font-en {
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
    }

    header {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255, 213, 217, 0.3);
      padding: 16px 24px;
    }

    .header-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-family: 'Montserrat', sans-serif;
      font-weight: 400;
      font-size: 24px;
      letter-spacing: 2px;
      color: var(--text-primary);
      text-decoration: none;
    }

    .logo span { color: var(--coral-rose); }

    .back-link {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--text-secondary);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link:hover { color: var(--coral-rose); }

    .container {
      max-width: 700px;
      margin: 0 auto;
      padding: 60px 24px;
    }

    .page-header {
      text-align: center;
      margin-bottom: 48px;
    }

    .page-title {
      font-size: 28px;
      font-weight: 300;
      margin-bottom: 16px;
    }

    .page-subtitle {
      font-size: 14px;
      color: var(--text-secondary);
    }

    .content-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 48px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 24px;
    }

    .form-label {
      display: block;
      font-size: 14px;
      color: var(--text-secondary);
      margin-bottom: 10px;
      font-weight: 400;
    }

    .form-label .required {
      color: var(--coral-rose);
      margin-left: 4px;
    }

    .form-input {
      width: 100%;
      padding: 14px 18px;
      font-size: 15px;
      font-family: 'Noto Sans JP', sans-serif;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: var(--radius-md);
      background: var(--soft-mist);
      transition: all 0.3s ease;
      outline: none;
    }

    .form-input:focus {
      border-color: var(--coral-rose);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(255, 140, 165, 0.1);
    }

    .form-input::placeholder {
      color: var(--text-light);
    }

    .form-input.error {
      border-color: var(--error);
    }

    textarea.form-input {
      min-height: 160px;
      resize: vertical;
    }

    /* Checkbox Options */
    .checkbox-group {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .checkbox-option {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      background: var(--soft-mist);
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .checkbox-option:hover {
      background: var(--peach-glow);
    }

    .checkbox-option.selected {
      background: rgba(255, 140, 165, 0.15);
      border-color: var(--coral-rose);
    }

    .checkbox-option input {
      display: none;
    }

    .checkbox-option .check-icon {
      width: 18px;
      height: 18px;
      border: 2px solid rgba(0, 0, 0, 0.2);
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      font-size: 12px;
      color: transparent;
    }

    .checkbox-option.selected .check-icon {
      background: var(--coral-rose);
      border-color: var(--coral-rose);
      color: white;
    }

    .checkbox-option span:last-child {
      font-size: 14px;
      color: var(--text-primary);
    }

    /* Button */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 18px 40px;
      border-radius: 50px;
      font-size: 16px;
      font-family: 'Noto Sans JP', sans-serif;
      font-weight: 400;
      text-decoration: none;
      transition: all 0.3s ease;
      cursor: pointer;
      border: none;
    }

    .btn-primary {
      background: var(--coral-rose);
      color: var(--white);
      box-shadow: 0 8px 30px rgba(255, 140, 165, 0.3);
    }

    .btn-primary:hover {
      background: var(--coral-rose-hover);
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(255, 140, 165, 0.4);
    }

    .btn-primary:disabled {
      background: var(--text-light);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* LINE Support */
    .line-section {
      margin-top: 48px;
      padding-top: 40px;
      border-top: 1px solid var(--soft-mist);
      text-align: center;
    }

    .line-section h3 {
      font-size: 18px;
      font-weight: 300;
      margin-bottom: 12px;
    }

    .line-section p {
      font-size: 14px;
      color: var(--text-secondary);
      margin-bottom: 20px;
    }

    .btn-line {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 14px 32px;
      background: #06C755;
      color: white;
      border-radius: 50px;
      text-decoration: none;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .btn-line:hover {
      background: #05b34d;
      transform: translateY(-2px);
    }

    .btn-line svg {
      width: 24px;
      height: 24px;
    }

    /* Alert */
    .alert {
      padding: 16px 20px;
      border-radius: var(--radius-md);
      margin-bottom: 24px;
      font-size: 14px;
    }

    .alert-success {
      background: rgba(129, 199, 132, 0.15);
      border: 1px solid var(--success);
      color: #388E3C;
    }

    .alert-error {
      background: rgba(229, 115, 115, 0.15);
      border: 1px solid var(--error);
      color: var(--error);
    }

    /* Toast */
    .toast {
      position: fixed;
      top: 24px;
      right: 24px;
      padding: 16px 24px;
      background: var(--white);
      border-radius: var(--radius-md);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      transform: translateX(120%);
      transition: transform 0.4s ease;
      z-index: 1000;
    }

    .toast.show { transform: translateX(0); }
    .toast.success { border-left: 4px solid var(--success); }
    .toast.error { border-left: 4px solid var(--error); }

    footer {
      text-align: center;
      padding: 40px 24px;
      font-size: 12px;
      color: var(--text-light);
    }

    footer a {
      color: var(--coral-rose);
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .content-card {
        padding: 32px 24px;
      }

      .checkbox-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="header-inner">
      <a href="{{ url('/') }}" class="logo">FLOW<span>GRAM</span></a>
      <a href="{{ url('/') }}" class="back-link">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        トップへ戻る
      </a>
    </div>
  </header>

  <div class="container">
    <div class="page-header">
      <h1 class="page-title">お問い合わせ</h1>
      <p class="page-subtitle">ご質問・ご相談がありましたら、お気軽にお問い合わせください。</p>
    </div>

    <div class="content-card">
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-error">
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ url('/contact') }}" id="contactForm">
        @csrf
        
        <div class="form-group">
          <label class="form-label">相談内容<span class="required">*</span></label>
          <p style="font-size: 13px; color: var(--text-light); margin-bottom: 12px;">該当する項目を選択してください（複数選択可）</p>
          <div class="checkbox-group">
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="sns">
              <span class="check-icon">✓</span>
              <span>SNS相談</span>
            </label>
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="review">
              <span class="check-icon">✓</span>
              <span>動画添削</span>
            </label>
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="edit">
              <span class="check-icon">✓</span>
              <span>動画編集</span>
            </label>
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="counseling">
              <span class="check-icon">✓</span>
              <span>カウンセリング</span>
            </label>
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="subscription">
              <span class="check-icon">✓</span>
              <span>サブスク契約・解約</span>
            </label>
            <label class="checkbox-option" onclick="toggleCheckbox(this)">
              <input type="checkbox" name="topics[]" value="other">
              <span class="check-icon">✓</span>
              <span>その他</span>
            </label>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">お名前<span class="required">*</span></label>
          <input type="text" name="name" class="form-input" placeholder="山田 花子" value="{{ old('name', Auth::user()->name ?? '') }}" required>
        </div>

        <div class="form-group">
          <label class="form-label">メールアドレス<span class="required">*</span></label>
          <input type="email" name="email" class="form-input" placeholder="example@email.com" value="{{ old('email', Auth::user()->email ?? '') }}" required>
        </div>

        <div class="form-group">
          <label class="form-label">電話番号</label>
          <input type="tel" name="phone" class="form-input" placeholder="090-1234-5678" value="{{ old('phone', Auth::user()->phone ?? '') }}">
        </div>

        <div class="form-group">
          <label class="form-label">件名<span class="required">*</span></label>
          <input type="text" name="subject" class="form-input" placeholder="お問い合わせの件名" value="{{ old('subject') }}" required>
        </div>

        <div class="form-group">
          <label class="form-label">お問い合わせ内容<span class="required">*</span></label>
          <textarea name="message" class="form-input" placeholder="詳細をご記入ください" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
          送信する
        </button>
      </form>

      <div class="line-section">
        <h3>LINEでのお問い合わせ</h3>
        <p>より早くサポートが必要な場合は、公式LINEからもお問い合わせいただけます。</p>
        <a href="https://line.me" target="_blank" class="btn-line">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 5.58 2 10c0 2.03.94 3.89 2.5 5.33V20l3.5-2c1.27.42 2.61.67 4 .67 5.52 0 10-3.58 10-8S17.52 2 12 2z"/>
          </svg>
          LINEで相談する
        </a>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; {{ date('Y') }} FLOWGRAM. All rights reserved.</p>
    <p style="margin-top: 16px;">
      <a href="{{ url('/legal/tokushoho') }}">特定商取引法に基づく表記</a> ｜ 
      <a href="{{ url('/legal/privacy') }}">プライバシーポリシー</a> ｜ 
      <a href="{{ url('/legal/terms') }}">利用規約</a>
    </p>
  </footer>

  <div class="toast" id="toast">
    <span id="toastMessage"></span>
  </div>

  <script>
    function toggleCheckbox(element) {
      const checkbox = element.querySelector('input[type="checkbox"]');
      checkbox.checked = !checkbox.checked;
      element.classList.toggle('selected', checkbox.checked);
    }

    // Initialize selected state on page load
    document.querySelectorAll('.checkbox-option input:checked').forEach(input => {
      input.closest('.checkbox-option').classList.add('selected');
    });

    function showToast(message, type) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = message;
      toast.className = 'toast ' + type + ' show';
      setTimeout(() => toast.classList.remove('show'), 3000);
    }
  </script>
</body>
</html>

