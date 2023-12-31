<?php

namespace App\Actions\LineNotify;

use App\Models\ContactBook;
use App\Models\Student;
use App\Models\StudentParentSignContactBook;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LineNotifySendAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(

    ) {}

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
                    $cr = " \n";//換行字元
                    $contactBook = ContactBook::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->with('classNotifications', 'studentNotifications')->first();

                    $url = config('app.url') . '/response/' . $student->parentInfos->first()->id . '/' . $student->id ;
                    $message = $cr . '親愛的' . $student->parentInfos->first()->name . '您好';
                    $message .= $cr . $student->name . '同學的 今日聯絡事項如下:';
                    $index = 0;
                    Log::info($contactBook->classNotifications);
                    if ($contactBook) {
                        foreach ($contactBook->classNotifications as $index => $classNotification) {
                            $message .= $cr . ($index + 1) . '.' . $classNotification->content;
                        }
                    }
                    $index = 0;
                    $message .= $cr . '個人聯絡事項如下:';

                    foreach ($student->studentNotifications as $index => $studentNotification) {
                        $message .= $cr . ($index + 1) . '.' . $studentNotification->content;
                    }
                    $scores = $student->scores;
                    foreach ($scores as $score) {
                        $message .= $cr . $score->subject_id . ' 分數: ' . $score->score;
                    }

                    $message .= $cr . '請您確認後點擊下列連擊簽名' . $cr . '並提供您的寶貴回覆' . $cr . '(點擊連結即簽名完成,可不需回覆)' ;
                    $message .= $cr . $url;

                    foreach ($student->parentInfos as $parentInfo) {
                        if ($parentInfo->line_token) {
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

                                    $student->signed = 0;
                                    $student->save();
                                }
                            } catch (Exception $exc) {
                                //正則表達取出401
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
