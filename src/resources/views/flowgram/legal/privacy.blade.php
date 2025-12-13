<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>プライバシーポリシー | FLOWGRAM</title>
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
      --radius-md: 12px;
      --radius-lg: 16px;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Noto Sans JP', sans-serif;
      font-weight: 400;
      color: var(--text-primary);
      line-height: 1.8;
      background: var(--soft-mist);
      min-height: 100vh;
    }

    .font-en {
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
    }

    header {
      background: var(--white);
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
      max-width: 800px;
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
      color: var(--text-light);
    }

    .content-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 48px;
    }

    .section {
      margin-bottom: 40px;
    }

    .section:last-child {
      margin-bottom: 0;
    }

    .section h2 {
      font-size: 18px;
      font-weight: 400;
      margin-bottom: 16px;
      padding-bottom: 12px;
      border-bottom: 2px solid var(--peach-glow);
    }

    .section p {
      font-size: 14px;
      color: var(--text-secondary);
      margin-bottom: 12px;
    }

    .section p:last-child {
      margin-bottom: 0;
    }

    .section ul {
      list-style: none;
      margin: 16px 0;
    }

    .section ul li {
      font-size: 14px;
      color: var(--text-secondary);
      padding: 8px 0;
      padding-left: 20px;
      position: relative;
    }

    .section ul li::before {
      content: '•';
      color: var(--coral-rose);
      position: absolute;
      left: 0;
    }

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
      <h1 class="page-title">プライバシーポリシー</h1>
      <p class="page-subtitle">Privacy Policy</p>
    </div>

    <div class="content-card">
      <div class="section">
        <h2>1. はじめに</h2>
        <p>株式会社FLOWGRAM（以下「当社」）は、お客様の個人情報の保護を重要な責務と認識し、以下のとおりプライバシーポリシーを定め、個人情報の適切な取り扱いに努めます。</p>
      </div>

      <div class="section">
        <h2>2. 収集する個人情報</h2>
        <p>当社は、サービス提供のために以下の個人情報を収集することがあります。</p>
        <ul>
          <li>氏名</li>
          <li>メールアドレス</li>
          <li>電話番号</li>
          <li>住所（必要な場合）</li>
          <li>お支払い情報（決済代行会社を通じて処理）</li>
          <li>SNSアカウント情報（相談内容に関連する場合）</li>
        </ul>
      </div>

      <div class="section">
        <h2>3. 個人情報の利用目的</h2>
        <p>収集した個人情報は、以下の目的で利用いたします。</p>
        <ul>
          <li>サービスの提供・運営</li>
          <li>お客様からのお問い合わせへの対応</li>
          <li>サービスの改善・新サービスの開発</li>
          <li>重要なお知らせの送付</li>
          <li>キャンペーン・お得な情報のご案内（同意いただいた場合）</li>
        </ul>
      </div>

      <div class="section">
        <h2>4. 個人情報の第三者提供</h2>
        <p>当社は、以下の場合を除き、お客様の個人情報を第三者に提供することはありません。</p>
        <ul>
          <li>お客様の同意がある場合</li>
          <li>法令に基づく場合</li>
          <li>人の生命・身体・財産の保護に必要な場合</li>
          <li>サービス提供に必要な業務委託先への提供（適切な管理のもと）</li>
        </ul>
      </div>

      <div class="section">
        <h2>5. 個人情報の安全管理</h2>
        <p>当社は、個人情報への不正アクセス、紛失、破壊、改ざん、漏洩を防止するため、適切な安全管理措置を講じます。</p>
      </div>

      <div class="section">
        <h2>6. Cookieの使用</h2>
        <p>当社ウェブサイトでは、サービス向上のためCookieを使用することがあります。Cookieの使用を希望されない場合は、ブラウザの設定で無効にすることができます。</p>
      </div>

      <div class="section">
        <h2>7. 個人情報の開示・訂正・削除</h2>
        <p>お客様は、ご自身の個人情報について、開示・訂正・削除を請求することができます。ご希望の場合は、お問い合わせフォームよりご連絡ください。</p>
      </div>

      <div class="section">
        <h2>8. プライバシーポリシーの変更</h2>
        <p>当社は、必要に応じて本ポリシーを変更することがあります。変更後のポリシーは、当ウェブサイトに掲載した時点で効力を生じます。</p>
      </div>

      <div class="section">
        <h2>9. お問い合わせ</h2>
        <p>本ポリシーに関するお問い合わせは、以下までご連絡ください。</p>
        <p style="margin-top: 16px;">
          <strong>株式会社FLOWGRAM</strong><br>
          メール：info@flowgram.jp
        </p>
      </div>

      <p style="text-align: right; font-size: 13px; color: var(--text-light); margin-top: 40px;">
        制定日：{{ date('Y年m月d日') }}
      </p>
    </div>
  </div>

  <footer>
    <p>&copy; {{ date('Y') }} FLOWGRAM. All rights reserved.</p>
    <p style="margin-top: 16px;">
      <a href="{{ url('/legal/tokushoho') }}">特定商取引法に基づく表記</a> ｜ 
      <a href="{{ url('/legal/terms') }}">利用規約</a> ｜ 
      <a href="{{ url('/contact') }}">お問い合わせ</a>
    </p>
  </footer>
</body>
</html>

