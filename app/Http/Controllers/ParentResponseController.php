<?php

namespace App\Http\Controllers;

use App\Models\ParentInfo;
use App\Models\StudentParentSignContactBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class ParentResponseController extends Controller
{
    public function showResponseForm($token)
    {
        try {
            // 解析 JWT token
            $payload = JWTAuth::parseToken()->getPayload($token);
            $parent_id = $payload->get('parent_id');
            $student_id = $payload->get('student_id');
        } catch (\Exception $e) {
            // 處理令牌解析錯誤
            return response()->json(['error' => 'invalid_token'], 401);
        }

        $parentInfo = ParentInfo::find($parent_id);
        $parentInfo->load('student');
        $parentInfo->student->signed = 1;
        $parentInfo->student->save();

        return view('response', ['token' => $token]);
    }

    public function submitResponse(Request $request)
    {
        $token = $request->input('token');

        try {
            // 解析 JWT token
            $payload = JWTAuth::parseToken()->getPayload($token);
            $parent_id = $payload->get('parent_id');
            $student_id = $payload->get('student_id');
        } catch (\Exception $e) {
            // 處理令牌解析錯誤
            return response()->json(['error' => 'invalid_token'], 401);
        }

        $parentInfo = ParentInfo::find($parent_id);

        // 創建或更新資料庫記錄
        $record = StudentParentSignContactBook::updateOrCreate(
            [
                'student_id' => $student_id,
                'parent_infos_id' => $parent_id,
                'reply' => $request->input('message'),
                'sign_time' => now(),
            ]
        );

        // 如果需要，進行其他處理
        return view('response_success', ['parentInfo' => $parentInfo]);
    }
}
