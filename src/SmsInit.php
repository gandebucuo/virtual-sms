<?php
namespace VirtualSms;

define ('Ali', 'AliProvider');

class SmsInit
{
    public static function make($name,array $config,array $params)
    {
        $namespace = ucfirst($name);

        $application = "\\VirtualSms\\Providers\\{$namespace}";

        return new $application($config,$params);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::make($name,...$arguments);
    }
}
