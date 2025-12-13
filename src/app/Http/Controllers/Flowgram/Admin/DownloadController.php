<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::latest()->paginate(20);

        return view('flowgram.admin.downloads.index', compact('downloads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'category' => ['required', 'string'],
            'plan_required' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
            'file' => ['required', 'file', 'max:102400'], // 100MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('downloads', 'local');
        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        Download::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'plan_required' => $validated['plan_required'],
            'user_id' => $validated['user_id'],
            'file_path' => $path,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'is_public' => empty($validated['plan_required']) && empty($validated['user_id']),
            'is_active' => true,
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'ファイルをアップロードしました');
    }

    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'category' => ['required', 'string'],
            'plan_required' => ['nullable', 'string'],
            'is_active' => ['nullable'],
            'file' => ['nullable', 'file', 'max:102400'], // 100MB max
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'plan_required' => $validated['plan_required'],
            'is_public' => empty($validated['plan_required']),
            'is_active' => $request->has('is_active'),
        ];

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($download->file_path && Storage::disk('local')->exists($download->file_path)) {
                Storage::disk('local')->delete($download->file_path);
            }

            // Upload new file
            $file = $request->file('file');
            $path = $file->store('downloads', 'local');
            
            $updateData['file_path'] = $path;
            $updateData['file_name'] = $file->getClientOriginalName();
            $updateData['file_type'] = $file->getClientOriginalExtension();
            $updateData['file_size'] = $file->getSize();
        }

        $download->update($updateData);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'ファイル情報を更新しました');
    }

    public function download(Download $download)
    {
        if (!Storage::disk('local')->exists($download->file_path)) {
            return back()->with('error', 'ファイルが見つかりません。');
        }

        $filePath = Storage::disk('local')->path($download->file_path);
        return response()->download($filePath, $download->file_name);
    }

    public function destroy(Download $download)
    {
        if ($download->file_path) {
            Storage::disk('local')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'ファイルを削除しました');
    }
}

