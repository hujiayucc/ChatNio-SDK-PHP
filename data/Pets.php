<?php

namespace com\hujiayucc\chatnio\data;

use com\hujiayucc\chatnio\bean\Package;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\BuyException;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\GetClient;
use com\hujiayucc\chatnio\utils\PostClient;
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

    /**
     * 购买余额
     * 扣除 Deeptrain 钱包余额，返回支付状态
     * @param int $quota 购买点数 (1-99999)
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     * @throws BuyException 购买错误
     */
    public function buy(int $quota): bool
    {
        if ($quota < 1 || $quota > 99999) {
            throw new FiledException("购买点数范围为：1-99999");
        }

        try {
            $postClient = new PostClient("/buy", $this->key, array("quota" => $quota));
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($postClient->body());
        if ($postClient->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($postClient->statusCode() == 200) {
            if ($json->status) return true;
            else throw new BuyException($json->error);
        }
        throw new FiledException("Filed Error");
    }

    /**
     * 查询礼包获取情况，返回是否符合条件并领取
     * @return Package 礼包
     * @throws FiledException 字段错误
     * @throws AuthException 认证失败
     */
    public function Package(): Package
    {
        try {
            $getClient = new GetClient("/package", $this->key);
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($getClient->body());
        if ($getClient->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($getClient->statusCode() == 200 && $json->status) {
            $data = $json->data;
            return new Package($data->cert, $data->teenager);
        }
        throw new FiledException("Filed Error");
    }
}