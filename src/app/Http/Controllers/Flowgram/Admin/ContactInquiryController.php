<?php

namespace App\Http\Controllers\Flowgram\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'new');
        
        $inquiries = ContactInquiry::where('status', $status)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'new' => ContactInquiry::where('status', 'new')->count(),
            'in_progress' => ContactInquiry::where('status', 'in_progress')->count(),
            'resolved' => ContactInquiry::where('status', 'resolved')->count(),
        ];

        return view('flowgram.admin.inquiries.index', compact('inquiries', 'counts'));
    }

    public function show(ContactInquiry $inquiry)
    {
        return view('flowgram.admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, ContactInquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,in_progress,resolved'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $inquiry->update($validated);

        if ($validated['status'] === 'resolved' && !$inquiry->resolved_at) {
            $inquiry->update(['resolved_at' => now()]);
        }

        return redirect()->route('admin.inquiries.show', $inquiry)
            ->with('success', 'ステータスを更新しました');
    }

    public function destroy(ContactInquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', '問い合わせを削除しました');
    }
}

