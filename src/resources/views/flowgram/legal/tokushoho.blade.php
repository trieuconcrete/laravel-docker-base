<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>特定商取引法に基づく表記 | FLOWGRAM</title>
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

    /* Header */
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

    /* Main Content */
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

    .legal-table {
      width: 100%;
      border-collapse: collapse;
    }

    .legal-table tr {
      border-bottom: 1px solid var(--soft-mist);
    }

    .legal-table tr:last-child {
      border-bottom: none;
    }

    .legal-table th,
    .legal-table td {
      padding: 20px 0;
      font-size: 14px;
      text-align: left;
      vertical-align: top;
    }

    .legal-table th {
      width: 200px;
      color: var(--text-secondary);
      font-weight: 400;
      background: none;
    }

    .legal-table td {
      color: var(--text-primary);
    }

    /* Footer */
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

      .legal-table th,
      .legal-table td {
        display: block;
        width: 100%;
        padding: 12px 0;
      }

      .legal-table th {
        padding-bottom: 4px;
        font-weight: 500;
      }

      .legal-table tr {
        padding: 16px 0;
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
      <h1 class="page-title">特定商取引法に基づく表記</h1>
      <p class="page-subtitle">Notation based on the Specified Commercial Transaction Act</p>
    </div>

    <div class="content-card">
      <table class="legal-table">
        <tr>
          <th>販売業者</th>
          <td>株式会社FLOWGRAM</td>
        </tr>
        <tr>
          <th>運営統括責任者</th>
          <td>—</td>
        </tr>
        <tr>
          <th>所在地</th>
          <td>—</td>
        </tr>
        <tr>
          <th>電話番号</th>
          <td>—</td>
        </tr>
        <tr>
          <th>メールアドレス</th>
          <td>info@flowgram.jp</td>
        </tr>
        <tr>
          <th>販売URL</th>
          <td>https://flowgram.jp</td>
        </tr>
        <tr>
          <th>販売価格</th>
          <td>
            ベーシックプラン：月額1,980円（税込）<br>
            プレミアムプラン：月額4,980円（税込）<br>
            各種オプション料金は別途サービス内容をご確認ください。
          </td>
        </tr>
        <tr>
          <th>商品代金以外の必要料金</th>
          <td>なし</td>
        </tr>
        <tr>
          <th>お支払い方法</th>
          <td>クレジットカード決済</td>
        </tr>
        <tr>
          <th>お支払い時期</th>
          <td>お申し込み時に決済</td>
        </tr>
        <tr>
          <th>サービス提供時期</th>
          <td>決済確認後、即時ご利用いただけます。</td>
        </tr>
        <tr>
          <th>返品・キャンセルについて</th>
          <td>
            デジタルコンテンツの性質上、お申し込み後の返金・キャンセルは原則としてお受けしておりません。<br>
            月額プランは次回更新日の前日までに解約申請をいただくことで、次月以降の課金を停止できます。
          </td>
        </tr>
        <tr>
          <th>解約について</th>
          <td>
            マイページまたはお問い合わせフォームより解約申請をお願いいたします。<br>
            解約申請後、運営にて手続きを行い、完了次第メールにてご連絡いたします。
          </td>
        </tr>
      </table>
    </div>
  </div>

  <footer>
    <p>&copy; {{ date('Y') }} FLOWGRAM. All rights reserved.</p>
    <p style="margin-top: 16px;">
      <a href="{{ url('/legal/privacy') }}">プライバシーポリシー</a> ｜ 
      <a href="{{ url('/legal/terms') }}">利用規約</a> ｜ 
      <a href="{{ url('/contact') }}">お問い合わせ</a>
    </p>
  </footer>
</body>
</html>

