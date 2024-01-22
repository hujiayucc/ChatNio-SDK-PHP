<?php

namespace com\hujiayucc\chatnio\utils;

use com\hujiayucc\chatnio\ChatNio;
use Exception;

class GetClient
{
    private $response;
    private int $statusCode;

    /**
     * GET请求
     * @param string $url 请求url
     * @param string $key 秘钥
     * @throws Exception 访问出错
     */
    public function __construct(string $url, string $key)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, ChatNio::$API . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $key));

        $this->response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
    }

    /** 返回数据 */
    public function body(): string
    {
        return $this->response;
    }

    /** 状态码 */
    public function statusCode(): int
    {
        return $this->statusCode;
    }
}