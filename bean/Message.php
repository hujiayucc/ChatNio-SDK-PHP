<?php

namespace com\hujiayucc\chatnio\bean;

/** 消息 */
class Message
{
    private string $role;
    private string $content;
    public function __construct(string $role, string $content)
    {
        $this->role = $role;
        $this->content = $content;
    }

    /**
     * @return string 角色
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string 内容
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /** toString */
    public function __toString(): string
    {
        return "Message{" .
            "role=" . $this->role .
            ", content='" . $this->content . '\'' .
            '}';
    }
}