<?php

namespace com\hujiayucc\chatnio;

/** Use PHP Version 7.4+ */
class ChatNio
{
    /** @var string API地址 */
    public static string $API = "";

    /**
     * 创建一个ChatNio
     * @param string $key 秘钥
     * @param string $point API节点
     */
    public function __construct(string $key, string $point = "https://api.chatnio.net")
    {
        ChatNio::$API = $point;
        echo "key: " . $key . " API: " . ChatNio::$API;
    }
}