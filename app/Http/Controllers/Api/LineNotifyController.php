<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LineNotify;
use App\Models\ParentInfo;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $message = '【' . config('app.url') . '】綁定完成';
            $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'form_params' => [
                    'message' => $message,
                ]
            ]);
            return redirect()->route('platform.students.list');
        } catch (Exception $exc) {
            Log::error($exc);
            throw $exc;
        }
    }

    public function system(Request $request)
    {
        try {
            $res = $request->all();
            $client = new Client();
            $callbackUri = config('app.url') . '/api/system';
            Log::info(config('app.url'));
            Log::info(config('app.line_notify_system_client_id') . '|' . config('app.line_notify_system_client_secret'));
            $response = $client->request('POST', 'https://notify-bot.line.me/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $callbackUri,
                    'client_id' => config('app.line_notify_system_client_id'),
                    'client_secret' => config('app.line_notify_system_client_secret'),
                    'code' => $res['code'],
                ],
            ]);

            $accessToken = json_decode($response->getBody(), true)['access_token'];
            //紀錄access token
            $lineNotify = new LineNotify();
            //紀錄發送訊息
            // $lineNotifyMessage = new LineNotifyMessage;
            $lineNotify->code = $accessToken;
            $lineNotify->role = 'system';
            $lineNotify->save();
            $client = new Client();
            $message = '【' . env('APP_URL') . '】綁定完成';
            $response = $client->request('POST', 'https://notify-api.line.me/api/notify', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'form_params' => [
                    'message' => $message,
                ]
            ]);
            return redirect()->route('platform.systems.line.system');
        } catch (Exception $exc) {
            Log::error($exc);
            throw $exc;
        }
    }
}
