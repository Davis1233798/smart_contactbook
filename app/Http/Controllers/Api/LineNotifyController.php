<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LineNotify;
use App\Models\ParentInfo;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Platform\Models\User;

class LineNotifyController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $res = $request->all();
            Log::info($res);
            Log::info($res['code']);
            $client = new Client();
            $callbackUri = config('app.url') . '/api/callback';
            Log::info($callbackUri);
            Log::info(config('app.line_id') . '|' . config('app.line_secret'));
            $response = $client->request('POST', 'https://notify-bot.line.me/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $callbackUri,
                    'client_id' => config('app.line_id'),
                    'client_secret' => config('app.line_secret'),
                    'code' => $res['code'],
                ],
            ]);

            $accessToken = json_decode($response->getBody(), true)['access_token'];
            //紀錄access token
            $parent = ParentInfo::where('line_id', $res['state'])->first();
            //紀錄發送訊息
            // $lineNotifyMessage = new LineNotifyMessage;
            $parent->update(['line_token' => $accessToken]);

            $client = new Client();
            $cr = " \n"; //換行字元
            $message = '綁定完成';
            $message .= $cr . '【輕鬆簽名 溝通無誤】';
            $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'form_params' => [
                    'message' => $message,
                ]
            ]);
            return view('success');
        } catch (Exception $exc) {
            Log::error($exc);
            throw $exc;
        }
    }
    public function teacher(Request $request)
    {
        try {
            $res = $request->all();
            Log::info($res);
            Log::info($res['code']);
            $client = new Client();
            $callbackUri = config('app.url') . '/api/teacher';
            Log::info($callbackUri);
            Log::info(config('app.teacher_line_id') . '|' . config('app.teacher_line_secret'));
            $response = $client->request('POST', 'https://notify-bot.line.me/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $callbackUri,
                    'client_id' => config('app.teacher_line_id'),
                    'client_secret' => config('app.teacher_line_secret'),
                    'code' => $res['code'],
                ],
            ]);

            $accessToken = json_decode($response->getBody(), true)['access_token'];
            //紀錄access token
            $parent =   User::where('line_id', $res['state'])->first();
            Log::info($parent);
            Log::info($accessToken);
            //紀錄發送訊息
            // $lineNotifyMessage = new LineNotifyMessage;
            $parent->line_token = $accessToken;
            $parent->save();

            $client = new Client();
            $cr = " \n"; //換行字元
            $message = '綁定完成';
            $message .= $cr . '【輕鬆簽名 溝通無誤】';
            $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'form_params' => [
                    'message' => $message,
                ]
            ]);
            return view('success');
        } catch (Exception $exc) {
            Log::error($exc);
            throw $exc;
        }
    }
}
