<?php

namespace com\hujiayucc\chatnio\bean;

/** 消息段 */
class MessageSegment
{
    private string $message;
    private string $keyword;
    private int $quota;
    private bool $end;

    /**
     * @param string $body
     */
    public function __construct(string $body)
    {
        $json = json_decode($body);
        $this->message = $json->message;
        $this->keyword = $json->keyword;
        $this->quota = $json->quota;
        $this->end = $json->end;
    }

    /**
     * @return string 消息内容
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string Keyword
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return int 使用的点数
     */
    public function getQuota(): int
    {
        return $this->quota;
    }

    /**
     * @return bool 是否结束
     */
    public function isEnd(): bool
    {
        return $this->end;
    }
}