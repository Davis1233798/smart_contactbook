<?php

namespace App\Actions\LineNotify;

use App\Models\LineNotify;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LineNotifyTeacherSendAction
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
            $lineNotifyTokens = User::all()->pluck('line_token');

            if (!$lineNotifyTokens->isEmpty()) {
                foreach ($lineNotifyTokens as $token) {
                    try {
                        $cr = " \n"; //換行字元
                        $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $token->code,
                            ],
                            'form_params' => [
                                'message' => $cr . $this->message,
                            ],
                        ]);
                    } catch (Exception $exc) {
                        //正則表達取出401
                        if (preg_match('/"status":(\d+)/', $exc->getMessage(), $matches)) {
                            if ($matches[1] == '401') {
                                LineNotify::where('code', '=', $token->code)->delete();
                                $message = 'line token : ' . $token->code . ' 401 錯誤已刪除';
                                Log::error($message);

                                //return 避免throw,其他情境未發生過
                                return;
                            }
                        }
                        throw $exc;
                    }
                }
            } else {
                Log::error('尚未設定 line 通知帳號');
            }
        } catch (Exception $exc) {
            Log::error($exc->getMessage());
            throw $exc;
        }
    }
}
