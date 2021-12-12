<?php

namespace Rc1021\LaravelAdmin\Controllers;

use Rc1021\LaravelAdmin\Facades\LineNotify;

class LineNotifyAuthController
{
    /**
     * LINE-Notify 取消服務訊息通知
     *
     * @return void
     */
    public function cancel() 
    {
        $admin = LineNotify::UserModel()::findOrFail(request()->get('id'));
        # 若使用者已連動則進行取消連動作業
        if (!empty($admin['line_notify_token'])) {
            $this->revoke($admin);
            session()->flash('status', __('line::admin.Unlink'));
        }
        return redirect()->route('admin.setting');
    }

    /**
     * 註冊服務訊息通知
     *
     * @param [type] $store_id
     * @param [type] $user_id
     * @return void
     */
    public function callback() 
    {
        $code = request()->get('code');
        $admin = LineNotify::UserModel()::findOrFail(request()->get('id'));
        $callbackUrl = route(LineNotify::getRouteNameForCallback(), ['id' => $admin->id]);
        $admin->line_notify_auth_code = $code;
        $admin->save();
        ### LINE Access Token ###
        $this->getNotifyAccessToken($admin, $code, $callbackUrl);
        session()->flash('status', __('line::admin.Link complete'));
        return redirect()->route('admin.setting');
    }

    /**
     * 取消服務通知
     *
     * @param [type] $access_token
     * @return void
     */
    public function revoke($admin) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/revoke');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $admin['line_notify_token']
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
        /**
         * {"status":200,"message":"ok"}
         */
        if (in_array($output['status'],[200,401])) {
            $admin->line_notify_token = null;
            $admin->save();
        }
        return $output;
    }

    /**
     * 取得LINE Notify Access Token
     *
     * @param [type] $store_id
     * @param [type] $user_id
     * @param [type] $code
     * @param [type] $redirect_uri
     * @return void
     */
    private function getNotifyAccessToken($admin, $code, $redirect_uri) {

        $apiUrl = "https://notify-bot.line.me/oauth/token";

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'client_id' => LineNotify::getClientID(),
            'client_secret' => LineNotify::getClientSecret()
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $output = curl_exec($ch);
        curl_close($ch);
        /**
         * {
         *      "status": 200,
         *      "message": "access_token is issued",
         *      "access_token": "7giNDfFWoAO1trYBA34YyfA6IZmazQoF4rmWSqrTtb3"
         *  }
         */
        $result = json_decode($output, true);
        $admin->refresh();
        $admin->line_notify_token = $result['access_token'];
        $admin->save();
    }
}
