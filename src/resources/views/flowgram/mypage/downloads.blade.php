@extends('flowgram.layouts.mypage')

@section('title', 'ダウンロード資料')
@section('page_title', 'ダウンロード資料')

@section('content')
  <div class="section">
    <div class="section-header">
      <h2 class="section-title">ダウンロード資料</h2>
    </div>
    <div class="section-body">
      @if($downloads->count() > 0)
        <div class="download-list">
          @foreach($downloads as $download)
            <div class="download-item">
              <div class="download-icon">
                @switch($download->category)
                  @case('guide') 📄 @break
                  @case('report') 📊 @break
                  @case('bonus') 🎁 @break
                  @case('deliverable') 🎬 @break
                  @default 📁
                @endswitch
              </div>
              <div class="download-info">
                <h5>{{ $download->title }}</h5>
                <p>{{ $download->description }} • {{ strtoupper($download->file_type) }} • {{ $download->formatted_size }}</p>
              </div>
              <a href="{{ route('mypage.download', $download) }}" class="download-btn">ダウンロード</a>
            </div>
          @endforeach
        </div>
      @else
        <div class="no-data">
          <div class="no-data-icon">📁</div>
          <p>ダウンロード可能な資料はありません</p>
        </div>
      @endif
    </div>
  </div>
@endsection

