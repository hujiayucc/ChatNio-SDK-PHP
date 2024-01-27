<?php

namespace com\hujiayucc\chatnio;

$list = array(
    "data",
    "utils",
    "exception",
    "bean",
    "enums"
);
// 引入所有需要的文件
foreach ($list as $dir) {
    foreach (glob($dir . "/*.php") as $filename)
    {
        require_once $filename;
    }
}

use com\hujiayucc\chatnio\data\Pets;
use com\hujiayucc\chatnio\data\Subscribe;
use com\hujiayucc\chatnio\data\Tasks;

/** Use PHP Version 7.4+ */
class ChatNio
{
    /** @var string API地址 */
    public static string $API;
    private Pets $pets;
    private Tasks $tasks;
    private Subscribe $subscribe;

    /**
     * 创建一个ChatNio
     * @param string $key 秘钥
     * @param string $point API节点
     */
    public function __construct(string $key, string $point = "https://api.chatnio.net")
    {
        ChatNio::$API = $point;
        $this->pets = new Pets($key);
        $this->tasks = new Tasks($key);
        $this->subscribe = new Subscribe($key);
    }

    /** 余额 */
    public function Pets(): Pets
    {
        return $this->pets;
    }

    /** 对话 */
    public function Tasks(): Tasks
    {
        return $this->tasks;
    }

    /** 订阅和礼包 */
    public function Subscribe(): Subscribe
    {
        return $this->subscribe;
    }
}