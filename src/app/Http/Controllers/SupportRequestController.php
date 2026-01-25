<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;

class SupportRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'message.required' => 'Vui lòng nhập nội dung cần hỗ trợ',
        ]);

        SupportRequest::create($validated);

        return redirect()->back()->with('success', 'Yêu cầu hỗ trợ của bạn đã được gửi thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!');
    }

    public function index()
    {
        $requests = SupportRequest::query()
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.support-requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, SupportRequest $supportRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $supportRequest->update($validated);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy(SupportRequest $supportRequest)
    {
        $supportRequest->delete();

        return redirect()->back()->with('success', 'Đã xóa yêu cầu hỗ trợ!');
    }
}
