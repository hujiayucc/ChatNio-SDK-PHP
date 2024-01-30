<?php

namespace com\hujiayucc\chatnio\data;

use com\hujiayucc\chatnio\enums\SubLevel;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\BuyException;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\GetClient;
use com\hujiayucc\chatnio\utils\PostClient;
use Exception;

/** 订阅和礼包 */
class Subscribe
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 查询订阅状态
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     */
    public function isSubscribed(): bool
    {
        try {
            $client = new GetClient("/subscription", $this->key);
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());
        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            return $json->is_subscribed;
        }

        throw new FiledException("Get Subscription Failed");
    }

    /**
     * 查询订阅剩余天数
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     */
    public function expired(): int
    {
        try {
            $client = new GetClient("/subscription", $this->key);
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());

        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            return $json->expired;
        }

        throw new FiledException("Get Subscription Failed");
    }

    /**
     * 购买订阅，从 Deeptrain 钱包扣除余额，返回订阅状态
     * @param int $month 购买月数
     * @param SubLevel $level 订阅级别
     * @throws BuyException
     * @throws AuthException
     * @throws FiledException
     */
    public function buy(int $month, SubLevel $level): bool
    {
        if ($month < 0 || $month > 999) {
            throw new FiledException("购买月数应为 0 至 999 之间");
        } elseif ($level->getLevel() == SubLevel::Normal) {
            throw new FiledException("订阅级别不能为普通用户");
        }

        try {
            $client = new PostClient("/subscribe", $this->key,
                array(
                    "month" => $month,
                    "level" => $level->getLevel()
                )
            );
        } catch (Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());
        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            return true;
        } elseif ($client->statusCode() == 200 && !$json->status) {
            throw new BuyException($json->error);
        }

        throw new FiledException("Buy Subscription Failed");
    }
}