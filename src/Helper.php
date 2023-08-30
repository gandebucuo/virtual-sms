<?php
namespace VirtualSms;

class Helper{

    //处理curl json响应格式
    public static function  curl_response_json($options)
    {
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,1);
        if($response['Message'] == 'OK'){
            return ['status'=>200,'msg'=>'发送成功'];
        }
        return ['status'=>400,'msg'=>$response['Message']];
    }
}
