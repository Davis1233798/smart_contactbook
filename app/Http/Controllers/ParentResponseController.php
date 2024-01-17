<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\StudentParentSignContactBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ParentResponseController extends Controller
{
    public function showResponseForm($parent_id)
    {
        $parent = Crypt::decryptString($parent_id);
        $parentInfo = ParentInfo::find($parent);
        $parentInfo->load('student');
        $parentInfo->student->signed = 1;
        $parentInfo->student->save();

        // 可以加入更多邏輯，例如獲取學生信息等 
        return view('response', ['parentInfo' => $parentInfo, 'student' => $parentInfo->student]);
    }

    public function submitResponse($parent_id, $student_id, Request $request)
    {
        // 解密 parent_id 和 student_id
        $decryptedParentId = Crypt::decryptString($parent_id);
        $decryptedStudentId = Crypt::decryptString($student_id);

        $parentInfo = ParentInfo::find($decryptedParentId);

        // 創建或更新資料庫記錄
        $record = StudentParentSignContactBook::updateOrCreate(
            [
                'student_id' => $decryptedStudentId,
                'parent_infos_id' => $decryptedParentId,
                'reply' => $request->message,
                'sign_time' => now(),
            ]
        );

        // 如果需要，進行其他處理
        return view('response_success', ['parentInfo' => $parentInfo]);
    }
}
