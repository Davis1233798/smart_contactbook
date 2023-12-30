<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use Illuminate\Http\Request;

class ParentResponseController extends Controller
{
    public function showResponseForm($parent_id)
    {
        $parentInfo = ParentInfo::findOrFail($parent_id);
        // 可以加入更多邏輯，例如獲取學生信息等
        return view('response', ['parentInfo' => $parentInfo]);
    }

    public function saveResponse(Request $request, $parent_id)
    {
        // 處理表單提交，保存留言
        // 這裡需要實現具體的保存邏輯
        return redirect()->back()->with('success', '留言已保存');
    }
}
