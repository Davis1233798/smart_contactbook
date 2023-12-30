<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\StudentParentSignContactBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ParentResponseController extends Controller
{
    public function showResponseForm($parent_id)
    {
        $parentInfo = ParentInfo::findOrFail($parent_id)->with('student')->first();
        $parentInfo->student->signed = 1;
        $parentInfo->student->save();

        // 可以加入更多邏輯，例如獲取學生信息等
        return view('response', ['parentInfo' => $parentInfo]);
    }

    public function submitResponse(Request $request)
    {
        Log::info($request->all());
        // 驗證輸入數據
        $validated = $request->validate([
            'parent_id' => 'required|exists:parent_infos,id',
            'contact_book_id' => 'required|exists:contact_books,id',
            'message' => 'required',
        ]);

        // 創建或更新資料庫記錄

        $record = StudentParentSignContactBook::updateOrCreate(
            [
                'student_id' => $request->student_id, // 確保這個參數是從表單中傳遞的
                'contact_book_id' => $request->contact_book_id,
                'parent_infos_id' => $request->parent_id,
            ],
            [
                'url' => url()->current(), // 當前 URL 或其他適合的 URL
                'reply' => $request->message,
                'sign_time' => now(),
                'content' => '家長留言內容', // 如果需要，您可以在這裡添加更多的內容
            ]
        );

        // 如果需要，進行其他處理

        return redirect()->back()->with('success', '您的回應已提交。');
    }
}
