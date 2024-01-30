<?php

namespace com\hujiayucc\chatnio\bean;

/** 对话Token */
class Token
{
    private string $token;
    private int $id;

    /**
     * 对话Token，默认为匿名和新对话
     * @param string $token JWT Token/API Key (匿名: anonymous)
     * @param int $id 对话ID (新建：-1)
     */
    public function __construct(string $token = "anonymous", int $id = -1)
    {
        $this->token = $token;
        $this->id = $id;
    }

    /**
     * @return string JWT Token/API Key
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int 对话ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string JSON 字符串
     */
    public function __toString(): string
    {
        return json_encode(array(
            "token" => $this->token,
            "id" => $this->id
        ));
    }
}