<?php

namespace App\Actions\LineNotify;

use App\Models\ContactBook;
use App\Models\Student;
use App\Models\StudentParentSignContactBook;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Facades\JWTAuth;

class LineNotifySendAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the action.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function execute()
    {
        // Log::info('into execute');
        try {
            $client = new Client();

            Student::where('id', '!=', '0')->with('parentInfos', 'scores', 'studentNotifications')->chunk(100, function ($students) use ($client) {
                foreach ($students as $student) {

                    if ($student->parentInfos->isEmpty()) {
                        continue;
                    }
                    $cr = " \n"; //換行字元
                    $contactBook = ContactBook::where('created_at', '>=', now()
                        ->startOfDay())
                        ->where('created_at', '<=', now()->endOfDay())
                        ->with('classNotifications', 'studentNotifications', 'schoolNotificationContents')
                        ->first();

                    $encryptedParams = Crypt::encrypt(['parent_id' => $student->parentInfos->first()->id, 'student_id' => $student->id]);
                    $url = config('app.url') . '/response/' . $encryptedParams;
                    $message = $cr . '親愛的' . $student->parentInfos->first()->name . '您好';
                    $message .= $cr . $student->name . '同學的' . $cr . '學校通知事項如下:';
                    $index = 0;
                    if ($contactBook) {
                        foreach ($contactBook->schoolNotificationContents as $index => $schoolNotificationContent) {
                            $message .= $cr . ($index + 1) . '.' . $schoolNotificationContent->content;
                        }
                    }
                    $index = 0;
                    $message .= $cr . '今日聯絡事項如下:';
                    if ($contactBook) {
                        foreach ($contactBook->classNotifications as $index => $classNotification) {
                            $message .= $cr . ($index + 1) . '.' . $classNotification->content;
                        }
                    }
                    $index = 0;
                    $message .= $cr . '個人通知事項如下:';

                    foreach ($student->studentNotifications as $index => $studentNotification) {
                        $message .= $cr . ($index + 1) . '.' . $studentNotification->content;
                    }
                    // Generate random subjects and scores
                    $subjects = ['國文', '英文', '數學', '自然', '歷史', '生物'];
                    $scores = [];

                    for ($i = 0; $i < 3; $i++) {
                        $subject = $subjects[$i];
                        $score = rand(60, 100);
                        $scores[$subject] = $score;
                    }

                    $message .= $cr . '考試分數如下:';
                    foreach ($scores as $subject => $score) {
                        $message .= $cr . $subject . ' 分數: ' . $score;
                    }
                    $message .= $cr . '請您確認後點擊下列連結簽名' . $cr . '並提供您的寶貴回覆' . $cr . '(點擊連結即簽名完成,可不需回覆)';
                    $message .= $cr . $url;

                    foreach ($student->parentInfos as $parentInfo) {
                        if ($parentInfo->line_token) {
                            Log::info('into line_token');
                            Log::info($parentInfo->line_token);
                            try {
                                $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                                    'headers' => [
                                        'Authorization' => 'Bearer ' . $parentInfo->line_token,
                                    ],
                                    'form_params' => [
                                        'message' => $message,
                                    ],
                                ]);

                                if ($response->getStatusCode() == 200) {
                                    //改變簽名狀態
                                    Log::info('into 200');
                                    $student->signed = 0;
                                    $student->save();
                                }
                            } catch (Exception $exc) {
                                //正則表達取出401
                                Log::error($exc);
                                if (preg_match('/"status":(\d+)/', $exc->getMessage(), $matches)) {
                                    if ($matches[1] == '401') {
                                        $parentInfo->update(['line_token' => null]);
                                        $message = 'line token : ' . $parentInfo->line_token . ' 401 錯誤已刪除';
                                        Log::error($message);

                                        //return 避免throw,其他情境未發生過
                                        return;
                                    }
                                }
                                throw $exc;
                            }
                        }
                    }
                }
            });
        } catch (Exception $exc) {
            Log::error($exc->getMessage());
            throw $exc;
        }
    }
}
