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
    public string $message;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(
        string $message
    ) {
        $this->message = $message;
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

            Student::where('id', '!=', '0')->with('parentInfos', 'contactBooks')->chunk(100, function ($students) use ($client) {
                foreach ($students as $student) {
                    // Log::info($student->parentInfos);
                    // Log::info($student->contactBooks);
                    if ($student->parentInfos->isEmpty()) {
                        continue;
                    }
                    $cr = " \n";//換行字元
                    $contactBook = ContactBook::where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->with('classNotifications', 'studentNotifications')->first();

                    $url = config('app.url') . '/' . $student->parentInfos->first()->id . '/' . $contactBook . '/response';
                    $message = $cr . '親愛的' . $student->parentInfos->first()->name . '您好';
                    $message .= $cr . $student->name . '同學的 今日聯絡簿 聯絡事項如下:';
                    $index = 0;
                    // foreach ($contactBook->classNotifications as $index => $classNotification) {
                    //     $message .= $cr . ($index + 1) . '.' . $classNotification->content;
                    // }
                    $message .= $cr . '1.明天請穿校服';
                    $message .= $cr . '2.明天請攜帶體育用品';
                    $message .= $cr . '3.明天請攜帶國文課本';
                    $message .= $cr . '注意事項如下:';
                    $index = 0;
                    $message .= $cr . '1.今日上學遲到';
                    $message .= $cr . '2.今日國文課踴躍回答問題';
                    $message .= $cr . '3.今日數學課睡覺';

                    // foreach ($contactBook->studentNotifications as $index => $studentNotification) {
                    //     $message .= $cr . ($index + 1) . '.' . $studentNotification->content;
                    // }
                    $message .= $cr . '今日小考成績如下:';
                    $message .= $cr . '國文: 85分';
                    $message .= $cr . '數學: 75分';
                    $message .= $cr . '英文: 25分';
                    $message .= $cr . '自然: 100分';
                    // Retrieve the scores for today's date
                    // $scores = $student->scores()->whereDate('created_at', now())->get();
                    // foreach ($scores as $score) {
                    //     $message .= $cr . $score->subject_id . ' 分數: ' . $score->score;
                    // }

                    $message .= $cr . '請您確認後點擊下列連擊簽名 並提供您的寶貴回覆';
                    $message .= $cr . $url;

                    $record = new StudentParentSignContactBook();
                    $record->student_id = $student->id;
                    $record->contact_book_id = $student->contactBooks->first()->id;
                    $record->url = $url;
                    $record->content = $message;
                    $record->save();
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
