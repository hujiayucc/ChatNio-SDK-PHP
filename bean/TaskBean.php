<?php

namespace com\hujiayucc\chatnio\bean;

/** 对话Bean */
class TaskBean
{
    private int $id;
    private int $userId;
    private string $name;
    private string $model;
    private bool $enableWeb;
    private array $message;
    /** 对话Bean */
    public function __construct(
        int $id,
        int $userId,
        string $name,
        string $model,
        bool $enableWeb,
        array $message
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        if (empty($message)) $this->message = $message;
        $this->model = $model;
        $this->enableWeb = $enableWeb;
    }

    /**
     * @return int 对话ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int 用户ID
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string 对话名称
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string 消息内容
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @return string 模型
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return bool 是否启用web
     */
    public function isEnableWeb(): bool
    {
        return $this->enableWeb;
    }

    /** toString */
    public function __toString(): string
    {
        return "TaskBean{" .
            "id=" . $this->id .
            ", userId=" . $this->userId .
            ", name='" . $this->name . '\'' .
            ", message='" . (isset($this->message) ? json_encode($this->message) : "null") . '\'' .
            ", model='" . $this->model . '\'' .
            ", enableWeb=" . ($this->enableWeb ? "true" : "false") .
            '}';
    }
}