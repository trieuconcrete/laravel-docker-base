<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>利用規約 | FLOWGRAM</title>
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

    .section ol {
      margin: 16px 0;
      padding-left: 24px;
    }

    .section ol li {
      font-size: 14px;
      color: var(--text-secondary);
      padding: 8px 0;
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
      <h1 class="page-title">利用規約</h1>
      <p class="page-subtitle">Terms of Service</p>
    </div>

    <div class="content-card">
      <div class="section">
        <h2>第1条（適用）</h2>
        <p>本規約は、株式会社FLOWGRAM（以下「当社」）が提供するSNS運用相談サービス「FLOWGRAM」（以下「本サービス」）の利用に関する条件を定めるものです。</p>
        <p>本サービスをご利用いただくすべてのお客様（以下「会員」）は、本規約に同意したものとみなします。</p>
      </div>

      <div class="section">
        <h2>第2条（会員登録）</h2>
        <ol>
          <li>本サービスの利用を希望する方は、当社所定の方法により会員登録を行うものとします。</li>
          <li>当社は、登録申請者に以下の事由があると判断した場合、会員登録を拒否することがあります。
            <ul>
              <li>虚偽の情報を提供した場合</li>
              <li>過去に本規約に違反したことがある場合</li>
              <li>その他、当社が不適切と判断した場合</li>
            </ul>
          </li>
        </ol>
      </div>

      <div class="section">
        <h2>第3条（サービス内容）</h2>
        <p>本サービスは、以下の内容を含みます。</p>
        <ul>
          <li>SNS運用に関するチャット相談（平日10:00〜17:00）</li>
          <li>動画添削サービス</li>
          <li>個別カウンセリング</li>
          <li>動画編集サービス</li>
          <li>月次運営レポート（プレミアムプランのみ）</li>
        </ul>
        <p>サービスの詳細は、当社ウェブサイトに掲載する内容に従います。</p>
      </div>

      <div class="section">
        <h2>第4条（料金・支払い）</h2>
        <ol>
          <li>会員は、選択したプラン・オプションに応じた料金を支払うものとします。</li>
          <li>料金はクレジットカード決済にてお支払いいただきます。</li>
          <li>月額プランは、毎月自動更新されます。解約をご希望の場合は、次回更新日の前日までにお申し出ください。</li>
        </ol>
      </div>

      <div class="section">
        <h2>第5条（禁止事項）</h2>
        <p>会員は、本サービスの利用にあたり、以下の行為を行ってはなりません。</p>
        <ul>
          <li>法令または公序良俗に違反する行為</li>
          <li>当社または第三者の知的財産権を侵害する行為</li>
          <li>当社のサービス運営を妨害する行為</li>
          <li>他の会員に対する嫌がらせ、誹謗中傷</li>
          <li>虚偽の情報を登録・送信する行為</li>
          <li>本サービスで得た情報を第三者に無断で提供する行為</li>
          <li>その他、当社が不適切と判断する行為</li>
        </ul>
      </div>

      <div class="section">
        <h2>第6条（解約・退会）</h2>
        <ol>
          <li>会員は、マイページまたはお問い合わせフォームより解約・退会の申請を行うことができます。</li>
          <li>月額プランの解約は、申請後、当社にて手続きを行い、次回更新日をもって終了となります。</li>
          <li>既にお支払いいただいた料金の返金は、原則としていたしません。</li>
        </ol>
      </div>

      <div class="section">
        <h2>第7条（免責事項）</h2>
        <ol>
          <li>当社は、本サービスにより会員のSNSフォロワー数増加や売上向上等の成果を保証するものではありません。</li>
          <li>当社は、本サービスの中断・停止により会員に生じた損害について、責任を負いません。</li>
          <li>会員間または会員と第三者との間で生じた紛争について、当社は責任を負いません。</li>
        </ol>
      </div>

      <div class="section">
        <h2>第8条（サービスの変更・終了）</h2>
        <p>当社は、会員への事前通知をもって、本サービスの内容を変更、または提供を終了することができます。</p>
      </div>

      <div class="section">
        <h2>第9条（規約の変更）</h2>
        <p>当社は、必要と判断した場合、本規約を変更することができます。変更後の規約は、当ウェブサイトに掲載した時点で効力を生じます。</p>
      </div>

      <div class="section">
        <h2>第10条（準拠法・管轄裁判所）</h2>
        <p>本規約の解釈は日本法に準拠し、本サービスに関する紛争は、当社本店所在地を管轄する裁判所を専属的合意管轄とします。</p>
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
      <a href="{{ url('/legal/privacy') }}">プライバシーポリシー</a> ｜ 
      <a href="{{ url('/contact') }}">お問い合わせ</a>
    </p>
  </footer>
</body>
</html>

