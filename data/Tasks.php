<?php

namespace com\hujiayucc\chatnio\data;

require_once __DIR__ . "/../bean/Message.php";
require_once __DIR__ . "/../bean/TaskBean.php";
require_once __DIR__ . "/../exception/AuthException.php";
require_once __DIR__ . "/../exception/FiledException.php";
require_once __DIR__ . "/../utils/GetClient.php";

use com\hujiayucc\chatnio\bean\Message;
use com\hujiayucc\chatnio\bean\TaskBean;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\GetClient;

/** 对话 */
class Tasks
{
    private string $key;

    /**
     * 对话
     * @param string $key 秘钥
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 获取对话列表
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     */
    public function getTaskList(): array
    {
        try {
            $client = new GetClient("/conversation/list", $this->key);
        } catch (\Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());
        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            $list = array();
            $message = array();
            foreach ($json->data as $data) {
                if (!empty($data->message)) {
                    foreach ($data->message as $item) {
                        $message[] = new Message($item->role, $item->content);
                    }
                }
                $list[] = new TaskBean($data->id, $data->user_id, $data->name, $data->model, $data->enable_web, $message);
            }
            return $list;
        } elseif ($client->statusCode() == 200 && !$json->status) {
            throw new FiledException($json->message);
        }

        throw new FiledException("Get TaskList failed");
    }

    /**
     * 获取单个对话
     * @param int $id 对话ID
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     */
    public function getTask(int $id): TaskBean
    {
        try {
            $client = new GetClient("/conversation/load?id=" . $id, $this->key);
        } catch (\Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());
        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            $data = $json->data;
            if (!empty($data->message)) {
                $message = array();
                foreach ($data->message as $item) {
                    $message[] = new Message($item->role, $item->content);
                }
            } else {
                $message = null;
            }
            return new TaskBean($json->data->id, $json->data->user_id, $json->data->name, $json->data->model, $json->data->enable_web, $message);
        } elseif ($client->statusCode() == 200 && !$json->status) {
            throw new FiledException($json->message);
        }

        throw new FiledException("Get Task failed");
    }

    /**
     * 删除对话
     * @param int $id 对话ID
     * @throws AuthException 认证失败
     * @throws FiledException 字段错误
     */
    public function deleteTask(int $id): bool
    {
        try {
            $client = new GetClient("/conversation/delete?id=" . $id, $this->key);
        } catch (\Exception $e) {
            throw new FiledException($e->getMessage());
        }

        $json = json_decode($client->body());
        if ($client->statusCode() == 401) {
            throw new AuthException("Unauthorized");
        } elseif ($client->statusCode() == 200 && $json->status) {
            return $json->status;
        } elseif ($client->statusCode() == 200 && !$json->status) {
            throw new AuthException($json->message);
        }

        throw new FiledException("Delete Task failed");
    }
}