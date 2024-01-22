<?php

namespace com\hujiayucc\chatnio\data;

use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\GetClient;
use Exception;

/** 余额 */
class Pets
{
    private string $key;
    /**
     * 余额
     * @param string $key 秘钥
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 获取余额
     * @throws FiledException 字段错误
     * @throws AuthException 认证错误
     */
    public function getQuota(): float
    {
        try {
            $getClient = new GetClient("/quota", $this->key);
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }
        $json = json_decode($getClient->body());
        if ($getClient->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($getClient->statusCode() == 200 && $json->status) {
            return $json->quota;
        }
        throw new FiledException("Filed Error");
    }
}