<?php

namespace com\hujiayucc\chatnio\utils;

use com\hujiayucc\chatnio\ChatNio;
use Exception;

class PostClient
{
    private $response;
    private int $statusCode;

    /**
     * POST请求
     * @param string $path 请求url路径
     * @param string $key 秘钥
     * @param array $data 发送的数据
     * @throws Exception 访问出错
     */
    public function __construct(string $path, string $key, array $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, ChatNio::$API . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: " . $key,
            'Content-Type: application/json',
        ));

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
