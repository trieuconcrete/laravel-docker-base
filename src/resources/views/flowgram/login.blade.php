<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ログイン | FLOWGRAM</title>
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
      --radius-xl: 24px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Noto Sans JP', sans-serif;
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.8;
      min-height: 100vh;
      display: flex;
      background: linear-gradient(135deg, var(--white) 0%, var(--blush-pink) 50%, var(--lavender-haze) 100%);
    }

    .font-en {
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
    }

    /* Layout */
    .auth-container {
      display: flex;
      width: 100%;
      min-height: 100vh;
    }

    /* Left Panel - Branding */
    .auth-branding {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    .auth-branding::before {
      content: '';
      position: absolute;
      top: -30%;
      left: -30%;
      width: 80%;
      height: 80%;
      background: radial-gradient(ellipse, rgba(255, 213, 217, 0.5) 0%, transparent 70%);
      pointer-events: none;
    }

    .auth-branding::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -20%;
      width: 60%;
      height: 60%;
      background: radial-gradient(ellipse, rgba(238, 231, 255, 0.6) 0%, transparent 70%);
      pointer-events: none;
    }

    .branding-content {
      position: relative;
      z-index: 1;
      text-align: center;
      max-width: 400px;
    }

    .branding-logo {
      font-family: 'Montserrat', sans-serif;
      font-weight: 400;
      font-size: 48px;
      letter-spacing: 3px;
      margin-bottom: 24px;
    }

    .branding-logo span {
      color: var(--coral-rose);
    }

    .branding-tagline {
      font-size: 18px;
      font-weight: 300;
      color: var(--text-secondary);
      margin-bottom: 40px;
      line-height: 1.8;
    }

    .branding-features {
      display: flex;
      flex-direction: column;
      gap: 16px;
      text-align: left;
    }

    .branding-feature {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      color: var(--text-secondary);
    }

    .branding-feature::before {
      content: '';
      width: 24px;
      height: 24px;
      background: var(--coral-rose);
      border-radius: 50%;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/%3E%3C/svg%3E");
      background-size: 14px;
      background-repeat: no-repeat;
      background-position: center;
      flex-shrink: 0;
    }

    /* Right Panel - Form */
    .auth-form-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      background: var(--white);
    }

    .auth-form-container {
      width: 100%;
      max-width: 400px;
    }

    .auth-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .auth-title {
      font-size: 28px;
      font-weight: 300;
      margin-bottom: 8px;
    }

    .auth-subtitle {
      font-size: 14px;
      color: var(--text-light);
    }

    /* Form Styles */
    .form-group {
      margin-bottom: 24px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 8px;
      font-weight: 400;
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

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      cursor: pointer;
    }

    .form-error {
      font-size: 12px;
      color: var(--error);
      margin-top: 6px;
      display: none;
    }

    .form-error.show {
      display: block;
    }

    /* Checkbox */
    .form-checkbox {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .form-checkbox input {
      display: none;
    }

    .checkbox-custom {
      width: 20px;
      height: 20px;
      border: 1px solid rgba(0, 0, 0, 0.15);
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .form-checkbox input:checked + .checkbox-custom {
      background: var(--coral-rose);
      border-color: var(--coral-rose);
    }

    .checkbox-custom::after {
      content: '✓';
      color: white;
      font-size: 12px;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .form-checkbox input:checked + .checkbox-custom::after {
      opacity: 1;
    }

    .checkbox-label {
      font-size: 13px;
      color: var(--text-secondary);
    }

    /* Form Actions */
    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }

    .form-link {
      font-size: 13px;
      color: var(--coral-rose);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .form-link:hover {
      color: var(--coral-rose-hover);
      text-decoration: underline;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 16px 32px;
      border-radius: 50px;
      font-size: 15px;
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

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 32px 0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(0, 0, 0, 0.1);
    }

    .divider span {
      font-size: 12px;
      color: var(--text-light);
    }

    /* Social Login */
    .social-buttons {
      display: flex;
      gap: 12px;
      margin-bottom: 32px;
    }

    .btn-social {
      flex: 1;
      padding: 14px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: var(--radius-md);
      background: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 14px;
      color: var(--text-primary);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-social:hover {
      background: var(--soft-mist);
      border-color: rgba(0, 0, 0, 0.15);
    }

    .btn-social svg {
      width: 20px;
      height: 20px;
    }

    /* Footer Link */
    .auth-footer {
      text-align: center;
      font-size: 14px;
      color: var(--text-secondary);
    }

    .auth-footer a {
      color: var(--coral-rose);
      text-decoration: none;
      font-weight: 400;
    }

    .auth-footer a:hover {
      text-decoration: underline;
    }

    /* Back to Home */
    .back-link {
      position: absolute;
      top: 24px;
      left: 24px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--text-secondary);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: var(--coral-rose);
    }

    /* Toast Notification */
    .toast {
      position: fixed;
      top: 24px;
      right: 24px;
      padding: 16px 24px;
      background: var(--white);
      border-radius: var(--radius-md);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateX(120%);
      transition: transform 0.4s ease;
      z-index: 1000;
    }

    .toast.show {
      transform: translateX(0);
    }

    .toast.success {
      border-left: 4px solid var(--success);
    }

    .toast.error {
      border-left: 4px solid var(--error);
    }

    .toast-message {
      font-size: 14px;
      color: var(--text-primary);
    }

    /* Alert Messages */
    .alert {
      padding: 12px 16px;
      border-radius: var(--radius-md);
      margin-bottom: 24px;
      font-size: 14px;
    }

    .alert-error {
      background: rgba(229, 115, 115, 0.1);
      border: 1px solid var(--error);
      color: var(--error);
    }

    .alert-success {
      background: rgba(129, 199, 132, 0.1);
      border: 1px solid var(--success);
      color: #388E3C;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .auth-branding {
        display: none;
      }

      .auth-form-panel {
        background: linear-gradient(135deg, var(--white) 0%, var(--blush-pink) 50%, var(--lavender-haze) 100%);
      }

      .auth-form-container {
        background: var(--white);
        padding: 48px 32px;
        border-radius: var(--radius-xl);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
      }
    }

    @media (max-width: 480px) {
      .auth-form-panel {
        padding: 24px;
      }

      .auth-form-container {
        padding: 32px 24px;
      }

      .social-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <a href="{{ url('/') }}" class="back-link">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
    トップへ戻る
  </a>

  <div class="auth-container">
    <!-- Left Panel - Branding -->
    <div class="auth-branding">
      <div class="branding-content">
        <div class="branding-logo">FLOW<span>GRAM</span></div>
        <p class="branding-tagline">
          SNSの悩み、いつでも<br>"相談できる"味方を。
        </p>
        <div class="branding-features">
          <div class="branding-feature">フォロワー1万人達成者のプロチーム</div>
          <div class="branding-feature">平日10:00〜17:00 無制限チャット相談</div>
          <div class="branding-feature">月額1,980円〜の手軽な料金</div>
        </div>
      </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="auth-form-panel">
      <div class="auth-form-container">
        <div class="auth-header">
          <h1 class="auth-title">ログイン</h1>
          <p class="auth-subtitle">アカウントにログインしてください</p>
        </div>

        @if ($errors->any())
          <div class="alert alert-error">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" id="loginForm">
          @csrf
          <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input 
              type="email" 
              name="email"
              class="form-input @error('email') error @enderror" 
              id="email"
              value="{{ old('email') }}"
              placeholder="example@email.com"
              required
            >
            @error('email')
              <p class="form-error show">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">パスワード</label>
            <div class="input-wrapper">
              <input 
                type="password" 
                name="password"
                class="form-input" 
                id="password"
                placeholder="パスワードを入力"
                required
              >
              <span class="input-icon" onclick="togglePassword()">
                <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </span>
            </div>
            @error('password')
              <p class="form-error show">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-actions">
            <label class="form-checkbox">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <span class="checkbox-custom"></span>
              <span class="checkbox-label">ログイン状態を保持</span>
            </label>
            <a href="{{ url('/forgot-password') }}" class="form-link">パスワードを忘れた方</a>
          </div>

          <button type="submit" class="btn btn-primary" id="submitBtn">
            ログイン
          </button>
        </form>

        <p class="auth-footer">
          アカウントをお持ちでない方は <a href="{{ url('/register') }}">新規登録</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast" id="toast">
    <span class="toast-message" id="toastMessage"></span>
  </div>

  <script>
    // Toggle Password Visibility
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
          <line x1="1" y1="1" x2="23" y2="23"/>
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        `;
      }
    }

    // Toast Notification
    function showToast(message, type) {
      const toast = document.getElementById('toast');
      const toastMessage = document.getElementById('toastMessage');
      
      toastMessage.textContent = message;
      toast.className = `toast ${type} show`;
      
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }

    // Input focus effects
    document.querySelectorAll('.form-input').forEach(input => {
      input.addEventListener('focus', () => {
        input.classList.remove('error');
        const errorEl = input.parentElement.querySelector('.form-error') || 
                       input.parentElement.parentElement.querySelector('.form-error');
        if (errorEl) errorEl.classList.remove('show');
      });
    });
  </script>

</body>
</html>

