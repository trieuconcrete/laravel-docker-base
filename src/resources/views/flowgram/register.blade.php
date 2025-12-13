<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>新規登録 | FLOWGRAM</title>
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

    .branding-steps {
      display: flex;
      flex-direction: column;
      gap: 20px;
      text-align: left;
    }

    .branding-step {
      display: flex;
      align-items: flex-start;
      gap: 16px;
    }

    .step-number {
      width: 32px;
      height: 32px;
      background: var(--coral-rose);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
      flex-shrink: 0;
    }

    .step-content h4 {
      font-size: 14px;
      font-weight: 400;
      margin-bottom: 4px;
    }

    .step-content p {
      font-size: 13px;
      color: var(--text-light);
    }

    /* Right Panel - Form */
    .auth-form-panel {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      background: var(--white);
      overflow-y: auto;
    }

    .auth-form-container {
      width: 100%;
      max-width: 440px;
      padding: 20px 0;
    }

    .auth-header {
      text-align: center;
      margin-bottom: 32px;
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

    /* Progress Steps */
    .progress-steps {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-bottom: 32px;
    }

    .progress-step {
      width: 40px;
      height: 4px;
      background: var(--soft-mist);
      border-radius: 2px;
      transition: background 0.3s ease;
    }

    .progress-step.active {
      background: var(--coral-rose);
    }

    .progress-step.completed {
      background: var(--success);
    }

    /* Form Styles */
    .form-section {
      display: none;
    }

    .form-section.active {
      display: block;
      animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 8px;
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

    .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 16px center;
      padding-right: 40px;
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

    .form-hint {
      font-size: 12px;
      color: var(--text-light);
      margin-top: 6px;
    }

    /* Password Strength */
    .password-strength {
      display: flex;
      gap: 4px;
      margin-top: 8px;
    }

    .strength-bar {
      flex: 1;
      height: 4px;
      background: var(--soft-mist);
      border-radius: 2px;
      transition: background 0.3s ease;
    }

    .strength-bar.weak { background: var(--error); }
    .strength-bar.medium { background: #FFB74D; }
    .strength-bar.strong { background: var(--success); }

    .strength-text {
      font-size: 12px;
      margin-top: 4px;
    }

    .strength-text.weak { color: var(--error); }
    .strength-text.medium { color: #FFB74D; }
    .strength-text.strong { color: var(--success); }

    /* Checkbox */
    .form-checkbox {
      display: flex;
      align-items: flex-start;
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
      flex-shrink: 0;
      margin-top: 2px;
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
      line-height: 1.6;
    }

    .checkbox-label a {
      color: var(--coral-rose);
      text-decoration: none;
    }

    .checkbox-label a:hover {
      text-decoration: underline;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
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
      width: 100%;
      background: var(--coral-rose);
      color: var(--white);
      box-shadow: 0 8px 30px rgba(255, 140, 165, 0.3);
    }

    .btn-primary:hover {
      background: var(--coral-rose-hover);
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(255, 140, 165, 0.4);
    }

    .btn-secondary {
      background: transparent;
      color: var(--text-secondary);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .btn-secondary:hover {
      background: var(--soft-mist);
    }

    .form-buttons {
      display: flex;
      gap: 12px;
      margin-top: 32px;
    }

    .form-buttons .btn {
      flex: 1;
    }

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      gap: 16px;
      margin: 24px 0;
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
      margin-bottom: 24px;
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
      text-decoration: none;
    }

    .btn-social:hover {
      background: var(--soft-mist);
      border-color: rgba(0, 0, 0, 0.15);
    }

    .btn-social svg {
      width: 20px;
      height: 20px;
    }

    /* Plan Selection */
    .plan-options {
      display: flex;
      flex-direction: column;
      gap: 16px;
      margin-bottom: 24px;
    }

    .plan-option {
      border: 2px solid rgba(0, 0, 0, 0.1);
      border-radius: var(--radius-md);
      padding: 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
    }

    .plan-option:hover {
      border-color: var(--coral-rose);
    }

    .plan-option.selected {
      border-color: var(--coral-rose);
      background: rgba(255, 140, 165, 0.05);
    }

    .plan-option input {
      display: none;
    }

    .plan-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;
    }

    .plan-name {
      font-size: 16px;
      font-weight: 400;
    }

    .plan-price {
      font-size: 20px;
      color: var(--coral-rose);
    }

    .plan-price span {
      font-size: 13px;
      color: var(--text-light);
    }

    .plan-desc {
      font-size: 13px;
      color: var(--text-secondary);
    }

    .plan-badge {
      position: absolute;
      top: -10px;
      right: 16px;
      background: var(--coral-rose);
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 11px;
    }

    .plan-check {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 24px;
      height: 24px;
      border: 2px solid rgba(0, 0, 0, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .plan-option.selected .plan-check {
      background: var(--coral-rose);
      border-color: var(--coral-rose);
    }

    .plan-check::after {
      content: '✓';
      color: white;
      font-size: 12px;
      opacity: 0;
    }

    .plan-option.selected .plan-check::after {
      opacity: 1;
    }

    /* Footer Link */
    .auth-footer {
      text-align: center;
      font-size: 14px;
      color: var(--text-secondary);
      margin-top: 24px;
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
      z-index: 10;
    }

    .back-link:hover {
      color: var(--coral-rose);
    }

    /* Success Message */
    .success-message {
      text-align: center;
      padding: 40px 0;
    }

    .success-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--peach-glow) 0%, var(--lavender-haze) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 24px;
      font-size: 36px;
    }

    .success-message h2 {
      font-size: 24px;
      font-weight: 300;
      margin-bottom: 12px;
    }

    .success-message p {
      font-size: 14px;
      color: var(--text-secondary);
      margin-bottom: 32px;
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
        padding: 40px 32px;
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

      .form-row {
        grid-template-columns: 1fr;
      }

      .social-buttons {
        flex-direction: column;
      }

      .form-buttons {
        flex-direction: column-reverse;
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
          今日から、SNSの<br>伸び方が変わる。
        </p>
        <div class="branding-steps">
          <div class="branding-step">
            <div class="step-number">1</div>
            <div class="step-content">
              <h4>無料会員登録</h4>
              <p>メールアドレスで簡単登録</p>
            </div>
          </div>
          <div class="branding-step">
            <div class="step-number">2</div>
            <div class="step-content">
              <h4>初回無料カウンセリング</h4>
              <p>あなたの目標をヒアリング</p>
            </div>
          </div>
          <div class="branding-step">
            <div class="step-number">3</div>
            <div class="step-content">
              <h4>チャット相談スタート</h4>
              <p>平日いつでも相談OK</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Panel - Register Form -->
    <div class="auth-form-panel">
      <div class="auth-form-container">
        <div class="auth-header">
          <h1 class="auth-title">新規登録</h1>
          <p class="auth-subtitle">まずは無料で会員登録</p>
        </div>

        @if ($errors->any())
          <div class="alert alert-error">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif

        <!-- Progress Steps -->
        <div class="progress-steps">
          <div class="progress-step active" id="progress1"></div>
          <div class="progress-step" id="progress2"></div>
          <div class="progress-step" id="progress3"></div>
        </div>

        <form method="POST" action="{{ url('/register') }}" id="registerForm">
          @csrf
          <!-- Step 1: Basic Info -->
          <div class="form-section active" id="step1">
            <div class="form-group">
              <label class="form-label">お名前<span class="required">*</span></label>
              <input type="text" name="name" class="form-input @error('name') error @enderror" id="name" placeholder="山田 花子" value="{{ old('name') }}" required>
              @error('name')
                <p class="form-error show">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">メールアドレス<span class="required">*</span></label>
              <input type="email" name="email" class="form-input @error('email') error @enderror" id="email" placeholder="example@email.com" value="{{ old('email') }}" required>
              @error('email')
                <p class="form-error show">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">電話番号<span class="required">*</span></label>
              <input type="tel" name="phone" class="form-input @error('phone') error @enderror" id="phone" placeholder="090-1234-5678" value="{{ old('phone') }}" required>
              @error('phone')
                <p class="form-error show">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">パスワード<span class="required">*</span></label>
              <div class="input-wrapper">
                <input type="password" name="password" class="form-input @error('password') error @enderror" id="password" placeholder="8文字以上" required minlength="8">
                <span class="input-icon" onclick="togglePassword('password')">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </span>
              </div>
              <div class="password-strength" id="strengthBars">
                <div class="strength-bar" id="bar1"></div>
                <div class="strength-bar" id="bar2"></div>
                <div class="strength-bar" id="bar3"></div>
                <div class="strength-bar" id="bar4"></div>
              </div>
              <p class="strength-text" id="strengthText"></p>
              @error('password')
                <p class="form-error show">{{ $message }}</p>
              @enderror
            </div>

            <div class="form-group">
              <label class="form-label">パスワード（確認）<span class="required">*</span></label>
              <div class="input-wrapper">
                <input type="password" name="password_confirmation" class="form-input" id="confirmPassword" placeholder="パスワードを再入力" required>
                <span class="input-icon" onclick="togglePassword('confirmPassword')">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </span>
              </div>
              <p class="form-error" id="confirmError">パスワードが一致しません</p>
            </div>

            <button type="button" class="btn btn-primary" onclick="nextStep(2)">
              次へ進む
            </button>

            <p class="auth-footer">
              すでにアカウントをお持ちの方は <a href="{{ url('/login') }}">ログイン</a>
            </p>
          </div>

          <!-- Step 2: Plan Selection -->
          <div class="form-section" id="step2">
            <h3 style="font-size: 18px; font-weight: 300; margin-bottom: 24px; text-align: center;">プランを選択</h3>
            
            <div class="plan-options">
              <label class="plan-option selected" onclick="selectPlan(this)">
                <input type="radio" name="plan" value="basic" checked>
                <div class="plan-check"></div>
                <div class="plan-header">
                  <span class="plan-name">ベーシックプラン</span>
                  <span class="plan-price">¥1,980<span>/月</span></span>
                </div>
                <p class="plan-desc">無制限チャット相談（平日10:00〜17:00）</p>
              </label>

              <label class="plan-option" onclick="selectPlan(this)">
                <input type="radio" name="plan" value="premium">
                <span class="plan-badge">人気</span>
                <div class="plan-check"></div>
                <div class="plan-header">
                  <span class="plan-name">プレミアムプラン</span>
                  <span class="plan-price">¥4,980<span>/月</span></span>
                </div>
                <p class="plan-desc">ベーシック＋月1回の運営レポート付き</p>
              </label>

              <label class="plan-option" onclick="selectPlan(this)">
                <input type="radio" name="plan" value="free">
                <div class="plan-check"></div>
                <div class="plan-header">
                  <span class="plan-name">無料会員</span>
                  <span class="plan-price">¥0</span>
                </div>
                <p class="plan-desc">動画編集のみ利用可能</p>
              </label>
            </div>

            <div class="form-buttons">
              <button type="button" class="btn btn-secondary" onclick="prevStep(1)">戻る</button>
              <button type="button" class="btn btn-primary" onclick="nextStep(3)">次へ進む</button>
            </div>
          </div>

          <!-- Step 3: Confirmation -->
          <div class="form-section" id="step3">
            <h3 style="font-size: 18px; font-weight: 300; margin-bottom: 24px; text-align: center;">利用規約への同意</h3>

            <div class="form-group">
              <label class="form-checkbox">
                <input type="checkbox" id="terms" name="terms" required>
                <span class="checkbox-custom"></span>
                <span class="checkbox-label">
                  <a href="#" target="_blank">利用規約</a>に同意します
                </span>
              </label>
            </div>

            <div class="form-group">
              <label class="form-checkbox">
                <input type="checkbox" id="privacy" name="privacy" required>
                <span class="checkbox-custom"></span>
                <span class="checkbox-label">
                  <a href="#" target="_blank">プライバシーポリシー</a>に同意します
                </span>
              </label>
            </div>

            <div class="form-group">
              <label class="form-checkbox">
                <input type="checkbox" id="marketing" name="marketing">
                <span class="checkbox-custom"></span>
                <span class="checkbox-label">
                  お得な情報やキャンペーンのお知らせを受け取る（任意）
                </span>
              </label>
            </div>

            <div class="form-buttons">
              <button type="button" class="btn btn-secondary" onclick="prevStep(2)">戻る</button>
              <button type="submit" class="btn btn-primary">登録を完了する</button>
            </div>
          </div>

          <!-- Success -->
          <div class="form-section" id="stepSuccess">
            <div class="success-message">
              <div class="success-icon">🎉</div>
              <h2>登録が完了しました！</h2>
              <p>ご登録いただいたメールアドレスに確認メールを送信しました。<br>メール内のリンクをクリックして登録を完了してください。</p>
              <a href="{{ url('/mypage') }}" class="btn btn-primary">マイページへ</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast" id="toast">
    <span class="toast-message" id="toastMessage"></span>
  </div>

  <script>
    let currentStep = 1;

    // Next Step
    function nextStep(step) {
      if (!validateStep(currentStep)) return;
      
      document.getElementById(`step${currentStep}`).classList.remove('active');
      document.getElementById(`progress${currentStep}`).classList.remove('active');
      document.getElementById(`progress${currentStep}`).classList.add('completed');
      
      currentStep = step;
      
      document.getElementById(`step${currentStep}`).classList.add('active');
      document.getElementById(`progress${currentStep}`).classList.add('active');
    }

    // Previous Step
    function prevStep(step) {
      document.getElementById(`step${currentStep}`).classList.remove('active');
      document.getElementById(`progress${currentStep}`).classList.remove('active');
      
      currentStep = step;
      
      document.getElementById(`step${currentStep}`).classList.add('active');
      document.getElementById(`progress${currentStep}`).classList.remove('completed');
      document.getElementById(`progress${currentStep}`).classList.add('active');
    }

    // Validate Step
    function validateStep(step) {
      if (step === 1) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (!name) {
          showToast('お名前を入力してください', 'error');
          return false;
        }
        
        if (!email || !email.includes('@')) {
          document.getElementById('email').classList.add('error');
          showToast('有効なメールアドレスを入力してください', 'error');
          return false;
        }

        if (!phone) {
          showToast('電話番号を入力してください', 'error');
          return false;
        }
        
        if (password.length < 8) {
          showToast('パスワードは8文字以上で入力してください', 'error');
          return false;
        }
        
        if (password !== confirmPassword) {
          document.getElementById('confirmPassword').classList.add('error');
          document.getElementById('confirmError').classList.add('show');
          return false;
        }
      }
      
      return true;
    }

    // Plan Selection
    function selectPlan(element) {
      document.querySelectorAll('.plan-option').forEach(opt => {
        opt.classList.remove('selected');
      });
      element.classList.add('selected');
    }

    // Toggle Password
    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const icon = input.parentElement.querySelector('.input-icon svg');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
          <line x1="1" y1="1" x2="23" y2="23"/>
        `;
      } else {
        input.type = 'password';
        icon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        `;
      }
    }

    // Password Strength
    document.getElementById('password').addEventListener('input', function(e) {
      const password = e.target.value;
      const bars = document.querySelectorAll('.strength-bar');
      const text = document.getElementById('strengthText');
      
      let strength = 0;
      if (password.length >= 8) strength++;
      if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
      if (password.match(/[0-9]/)) strength++;
      if (password.match(/[^a-zA-Z0-9]/)) strength++;
      
      bars.forEach((bar, index) => {
        bar.className = 'strength-bar';
        if (index < strength) {
          if (strength <= 1) bar.classList.add('weak');
          else if (strength <= 2) bar.classList.add('medium');
          else bar.classList.add('strong');
        }
      });
      
      if (password.length === 0) {
        text.textContent = '';
        text.className = 'strength-text';
      } else if (strength <= 1) {
        text.textContent = '弱い';
        text.className = 'strength-text weak';
      } else if (strength <= 2) {
        text.textContent = '普通';
        text.className = 'strength-text medium';
      } else {
        text.textContent = '強い';
        text.className = 'strength-text strong';
      }
    });

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

