<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\StudentParentSignContactBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Actions\LineNotify\LineNotifyTeacherSendAction;

class ParentResponseController extends Controller
{
    public function showResponseForm($encryptedParams)
    {
        // 解密參數
        $decrypted = Crypt::decrypt($encryptedParams);
        $parent_id = $decrypted['parent_id'];
        $student_id = $decrypted['student_id'];
        $parentInfo = ParentInfo::find($parent_id);
        $parentInfo->load('student');
        $action = app()->make(LineNotifyTeacherSendAction::class, ['message' => $parentInfo->student->name . '今日聯絡簿已簽']);
        $action->execute();
        $parentInfo->student->signed = 1;
        $parentInfo->student->save();

        // 再次加密 parent_id 和 student_id
        $token = Crypt::encrypt(['parent_id' => $parent_id, 'student_id' => $student_id]);

        // 傳遞 token 到視圖
        return view('response', ['parentInfo' => $parentInfo, 'student' => $parentInfo->student, 'token' => $token]);
    }

    public function submitResponse(Request $request)
    {
        // 解密 token 以獲取 parent_id 和 student_id
        $decrypted = Crypt::decrypt($request->token);
        $parent_id = $decrypted['parent_id'];
        $student_id = $decrypted['student_id'];

        $parentInfo = ParentInfo::find($parent_id);
        $cr = " \n"; //換行字元
        $url = config('app.url') . '/admin/student/' . $student_id . '/edit';
        $message = $parentInfo->student->name . '已回覆 :';
        $message .= $cr . $request->message;
        $message .= $cr . $url;
        $action = app()->make(LineNotifyTeacherSendAction::class, ['message' => $message]);
        $action->execute();
        // 創建或更新資料庫記錄
        $record = StudentParentSignContactBook::updateOrCreate(
            [
                'student_id' => $student_id,
                'parent_infos_id' => $parent_id,
                'reply' => $request->message,
                'sign_time' => now(),
            ]
        );

        // 如果需要，進行其他處理
        return view('response_success');
    }
}
