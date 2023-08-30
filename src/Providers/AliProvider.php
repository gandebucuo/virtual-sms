<?php
namespace VirtualSms\Providers;

use VirtualSms\Helper;

/**
 * 阿里云
 * Class AliProvider
 * @package VirtualCloud\Providers
 */
class AliProvider extends Helper
{
    private $config;            //配置项
    private $params;            //参数
    private $timestamp;         //GMT时间
    private $signature_nonce;   //签名盐值
    private $signature_method;  //签名加密方式


    public function __construct(array $config,$params)
    {
        $this->config           = $config;
        $this->params           = $params;
        $this->timestamp        = gmdate('Y-m-d\\TH:i:s\\Z');;
        $this->signature_nonce  = md5(uniqid() . uniqid(md5(microtime(true)), true));
        $this->signature_method = "HMAC-SHA1";
    }

    /**
     * 发送短信
     * @return array
     */
    public function sendSms()
    {
        $options = [
            CURLOPT_URL         => $this->createSendSmsUrl(),
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
        ];
        return helper::curl_response_json($options);
    }

    /**
     * 生成发送短信URL地址
     * @param $params
     * @return string
     */
    private function createSendSmsUrl()
    {
        $params = [
            "PhoneNumbers"  => $this->params['phoneNumbers'],
            "SignName"      => $this->params['signName'],
            "TemplateCode"  => $this->params['templateCode'],
            "TemplateParam" => isset($this->params['templateParam'])?$this->params['templateParam']:'',
            "Action"        => "SendSms",
            "Format"        => "JSON",
            "Version"       => "2017-05-25",
            "AccessKeyId"   => $this->config['access_key_id'],
            "SignatureNonce"=> $this->signature_nonce,
            "Timestamp"     => $this->timestamp,
            "SignatureMethod"=> $this->signature_method,
            "SignatureVersion" =>"1.0",
        ];

        $param_key = array_keys($params);
        sort($param_key);

        $canonicalizeQueryString = "";
        foreach ($param_key as $k=>$v){
            $canonicalizeQueryString .= self::encodeRFC3986($v) . "=" . self::encodeRFC3986( $params[$v]) . "&";
        }
        $canonicalizeQueryString = trim($canonicalizeQueryString,'&');

        $stringToSign =  "GET&" . self::encodeRFC3986("/") . "&" . self::encodeRFC3986($canonicalizeQueryString);

        $signature  = base64_encode(hash_hmac('sha1',utf8_encode($stringToSign),$this->config['access_key_secret'] . "&",true));

        $signature  = self::encodeRFC3986($signature);
        return  "https://dysmsapi.aliyuncs.com/?" . $canonicalizeQueryString . "&Signature=" . $signature;
    }

    /**
     * RFC3986 编码机制
     * @param $str
     * @return mixed
     */
    private static  function encodeRFC3986($str)
    {
        $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%2F', '%3F', '%23', '%5B', '%5D', '%20');
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "/", "?", "#", "[", "]", " ");
        return str_replace($replacements, $entities, urlencode($str));
    }
}
