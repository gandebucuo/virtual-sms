# 前言
###### 由于个人实际开发中使用官方SDK短信，大部分扩展功能都未使用到，因此开发此简约版发送短信功能，方面后续使用；若后续需要其他功能，将继续扩展。
# 说明
###### 由于官方SDK，单独使用发送短信功能，源码需要走很多流程验证判断，影响性能；特此开发简约版本发送短信，使用RPC风格接口，由官方API + 签名组成，因此不存在版本不兼容问题。
# 安装
#### 使用composer命令直接安装
```
composer require virtual-sms/sms
```
#### 或在composer.json添加包名后，执行composer install安装
```
{
    "require": {
        "virtual-sms/sms": "dev-main"
    }
}
```

# 使用方法
#### 发送短信
```
use VirtualCloud\SmsInit;
...
    $config   =  [
        'access_key_id'     => 'LTAI5t****EL4i9R6',
        'access_key_secret' => '2Ta711***mYXwF333',
    ];
    
    $params = [
        "phoneNumbers"  => "152******71",       //手机号
        "signName"      => "ABC商城",           //签名名称
        "templateCode"  => "SMS_203717462",     //模板CODE
        "templateParam" => '{"code":"123456"}', //短信参数，json格式
    ];
    
    $new    = SmsInit::make(Ali,$config,$params);
    //发送短信
    $result = $new->sendSms();
...
```
#### $config 配置参数说明
```
//阿里云
$congig = [
    'access_key_id'     => 'LTAI5t****EL4i9R6',
    'access_key_secret' => '2Ta711***mYXwF333',
]
```
# 联系我们
如需丰富扩展/其他业务/建议，请直接向1059636119@qq.com 发送邮箱；或添加微信，请说明来意奥




![个人微信](http://xiaonarun.oss-cn-beijing.aliyuncs.com/wx.jpg?x-oss-process=image/resize,m_fixed,h_340,w_300)
