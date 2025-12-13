@extends('flowgram.layouts.admin')

@section('title', '資料アップロード')
@section('breadcrumb', '資料アップロード')

@section('content')
  <div class="page-header flex">
    <div>
      <h1 class="page-title">資料アップロード</h1>
      <p class="page-subtitle">会員向けダウンロード資料の管理</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('fileModal')">+ ファイル追加</button>
  </div>

  <div class="card">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>ファイル名</th>
            <th>種類</th>
            <th>カテゴリ</th>
            <th>対象プラン</th>
            <th>ダウンロード数</th>
            <th>アップロード日</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @forelse($downloads as $download)
            <tr>
              <td>
                @switch($download->file_type)
                  @case('pdf') 📄 @break
                  @case('mp4') 🎬 @break
                  @case('zip') 📦 @break
                  @default 📁
                @endswitch
                {{ $download->title }}
              </td>
              <td>{{ strtoupper($download->file_type) }}</td>
              <td>
                @switch($download->category)
                  @case('guide') ガイド @break
                  @case('report') レポート @break
                  @case('bonus') ボーナス @break
                  @case('deliverable') 納品物 @break
                  @default その他
                @endswitch
              </td>
              <td>
                @if($download->is_public)
                  全プラン
                @elseif($download->plan_required)
                  {{ $download->plan_required == 'premium' ? 'プレミアム' : ($download->plan_required == 'basic' ? 'ベーシック' : $download->plan_required) }}
                @else
                  個別
                @endif
              </td>
              <td>{{ $download->download_count }}</td>
              <td>{{ $download->created_at->format('Y/m/d') }}</td>
              <td style="white-space:nowrap;">
                @if($download->fileExists())
                  <a href="{{ route('admin.downloads.download', $download) }}" class="btn btn-sm btn-primary" title="ダウンロード">⬇</a>
                @else
                  <span class="btn btn-sm" style="opacity:0.3;cursor:not-allowed;" title="ファイルなし">⬇</span>
                @endif
                <button class="btn btn-sm btn-secondary" onclick="openEditModal({{ json_encode($download) }})">編集</button>
                <form method="POST" action="{{ route('admin.downloads.destroy', $download) }}" style="display:inline;" onsubmit="return confirm('削除しますか？')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline">削除</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="text-align:center;padding:32px;color:var(--text-light);">ファイルがありません</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($downloads->hasPages())
      <div class="pagination">
        <div class="pagination-info">{{ $downloads->firstItem() }}-{{ $downloads->lastItem() }} / {{ $downloads->total() }}件</div>
        <div class="pagination-buttons">
          {{ $downloads->links() }}
        </div>
      </div>
    @endif
  </div>

  <!-- Upload Modal -->
  <div class="modal-overlay" id="fileModal">
    <div class="modal">
      <div class="modal-header">
        <h3 class="modal-title">ファイルアップロード</h3>
        <button class="modal-close" onclick="closeModal('fileModal')">✕</button>
      </div>
      <form method="POST" action="{{ route('admin.downloads.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">ファイル名（表示名）</label>
            <input type="text" name="title" class="form-input" placeholder="表示名を入力" required>
          </div>
          <div class="form-group">
            <label class="form-label">説明</label>
            <input type="text" name="description" class="form-input" placeholder="ファイルの説明">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">カテゴリ</label>
              <select name="category" class="form-input form-select">
                <option value="guide">ガイド</option>
                <option value="report">レポート</option>
                <option value="bonus">ボーナス</option>
                <option value="deliverable">納品物</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">対象プラン</label>
              <select name="plan_required" class="form-input form-select">
                <option value="">全プラン（公開）</option>
                <option value="basic">ベーシック以上</option>
                <option value="premium">プレミアムのみ</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">対象ユーザー（個別の場合）</label>
            <select name="user_id" class="form-input form-select">
              <option value="">全員</option>
              @foreach(\App\Models\User::where('role', 'user')->orderBy('name')->get() as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">ファイル</label>
            <input type="file" name="file" class="form-input" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal('fileModal')">キャンセル</button>
          <button type="submit" class="btn btn-primary">アップロード</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal-overlay" id="editModal">
    <div class="modal">
      <div class="modal-header">
        <h3 class="modal-title">ファイル編集</h3>
        <button class="modal-close" onclick="closeModal('editModal')">✕</button>
      </div>
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">ファイル名（表示名）</label>
            <input type="text" name="title" id="editTitle" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">説明</label>
            <input type="text" name="description" id="editDescription" class="form-input">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">カテゴリ</label>
              <select name="category" id="editCategory" class="form-input form-select">
                <option value="guide">ガイド</option>
                <option value="report">レポート</option>
                <option value="bonus">ボーナス</option>
                <option value="deliverable">納品物</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">対象プラン</label>
              <select name="plan_required" id="editPlan" class="form-input form-select">
                <option value="">全プラン（公開）</option>
                <option value="basic">ベーシック以上</option>
                <option value="premium">プレミアムのみ</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">
              <input type="checkbox" name="is_active" id="editActive" value="1"> 有効
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">キャンセル</button>
          <button type="submit" class="btn btn-primary">保存</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  function openEditModal(download) {
    const form = document.getElementById('editForm');
    form.action = '{{ route('admin.downloads.index') }}/' + download.id;
    document.getElementById('editTitle').value = download.title;
    document.getElementById('editDescription').value = download.description || '';
    document.getElementById('editCategory').value = download.category || 'guide';
    document.getElementById('editPlan').value = download.plan_required || '';
    document.getElementById('editActive').checked = download.is_active;
    openModal('editModal');
  }
@endsection

