# ChatNio SDK 使用文档

## 一、简介
为 [ChatNio](https://chatnio.net/) 提供的PHP平台SDK

## 二、快速开始

- 通过Composer 安装(1)

创建一个`composer.json`文件，然后将以下代码添加到`composer.json`中：

```json
{
  "require": {
    "hujiayucc/chatnio": "^x.x.x"
  }
}
```

然后在命令行中执行以下命令：

```shell
composer install # 安装
composer update # 更新
```

- 通过Composer 安装(2)

```shell
composer require hujiayucc/chatnio # 安装
composer update # 更新
```

- 使用

在开始使用 SDK 之前，你需要首先生成一个`ChatNio`实例，这需要提供一个由`ChatNio`服务提供的密钥：

```php
require_once 'vendor/autoload.php';

use com\hujiayucc\chatnio\ChatNio;
$key = "你的密钥";
$chatNio = new ChatNio(key);
```

## 三、余额
[相关API](https://docs.chatnio.net/kai-fa-zhe-zi-yuan/api-reference/pets)

```php
$package = $chatNio->Pets()->Package();
echo "\ncert: " . ($package->isCert() ? "true" : "false");
echo "\nTeenager: " . ($package->isTeenager() ? "true" : "false");

$subscribe = $chatNio->Subscribe();
echo "\n" . "isSubscribed: " . ($subscribe->isSubscribed() ? "true" : "false");
echo "\n" . "expired: " . $subscribe->expired();
$buy = $subscribe->buy(1, new SubLevel(SubLevel::Standard));
echo "\n" . ($buy ? "buy success" : "buy failed");
```

通过调用以下方法购买余额：

```php
echo "\n" . ($chatNio->Pets()->buy(1) ? "true" : "false");
```

## 四、对话
[相关API](https://docs.chatnio.net/kai-fa-zhe-zi-yuan/api-reference/dui-hua)

SDK 提供了一个便捷的对话查询方法：

```php
$tasks = $chatNio->Tasks();
$taskList = $tasks->getTaskList();
foreach ($taskList as $task) {
    echo "\n" . $task->__toString();
}
```

这将返回一个`TaskBean`对象的列表，你可以通过这些`TaskBean`对象获取例如任务的`id`、`userId`、`name`、`model`、`enableWeb`等信息，并且获取任务的`Message`消息列表。

## 五、订阅和礼包
[相关API](https://docs.chatnio.net/kai-fa-zhe-zi-yuan/api-reference/ding-yue-he-li-bao)

你可以使用SDK提供的方法查询订阅状态，购买订阅和续费等操作

```php
$package = $chatNio->Pets()->Package();
echo "\ncert: " . ($package->isCert() ? "true" : "false");
echo "\nTeenager: " . ($package->isTeenager() ? "true" : "false");
```

## 六、聊天
[相关API](https://docs.chatnio.net/kai-fa-zhe-zi-yuan/api-reference/liao-tian)
[模型API](https://api.chatnio.net/v1/models)

使用 SDK，你可以选择同步方式或异步方式进行消息发送。其中，`Token`对象用于指定用户或密钥和对话id，也可以设置为匿名或新对话。

### 1. 同步方式

```php
require_once __DIR__ . "/data/ChatAsync.php";
$async = new ChatAsync(new Token($key));
$async->sendMessage("写一段PHP调用WebSocket的示例");
echo "\n" . "async send success: " . $async->getMessages();
```
### 2. 异步方式

```php
require_once __DIR__ . "/data/ChatSync.php";
$sync = new ChatSync(new Token($key), new class extends CustomSync
{

    function onMessage(MessageSegment $message)
    {
        echo "\n" . $message->getMessage();
    }

    function onError(Exception $exception)
    {
        throw new FiledException($exception->getMessage());
    }
});

$sync->sendMessage("写一段PHP调用WebSocket的示例");
echo "\n" . "sync send success: " . $sync->getMessages();
```
在异步方式下，你可以重写 `onMessage`方法来接收消息，也可以重写 `onError`方法来处理错误。

## 七、调用实例
```php
<?php

require_once "ChatNio.php";

// 下面两个可以删掉，只是方便导入秘钥
global $key;
include "config.php";

use com\hujiayucc\chatnio\bean\MessageSegment;
use com\hujiayucc\chatnio\bean\Token;
use com\hujiayucc\chatnio\ChatNio;
use com\hujiayucc\chatnio\data\ChatAsync;
use com\hujiayucc\chatnio\data\ChatSync;
use com\hujiayucc\chatnio\enums\SubLevel;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\BuyException;
use com\hujiayucc\chatnio\exception\FiledException;
use com\hujiayucc\chatnio\utils\CustomSync;

$chatNio = new ChatNio($key);

try {
    echo $chatNio->Pets()->getQuota();
} catch (AuthException|FiledException $e) {
    echo("\n" . $e->getMessage());
}

try {
    echo "\n" . ($chatNio->Pets()->buy(1) ? "true" : "false");
    echo "\n" . $chatNio->Pets()->getQuota();
} catch (AuthException|BuyException|FiledException $e) {
    echo("\n" . $e->getMessage());
}

try {
    $package = $chatNio->Pets()->Package();
    echo "\ncert: " . ($package->isCert() ? "true" : "false");
    echo "\nTeenager: " . ($package->isTeenager() ? "true" : "false");
} catch (FiledException|AuthException $e) {
    echo("\n" . $e->getMessage());
}

try {
    $tasks = $chatNio->Tasks();
    $taskList = $tasks->getTaskList();
    foreach ($taskList as $task) {
        echo "\n" . $task->__toString();
    }
} catch (AuthException|FiledException $e) {
    echo("\n" . $e->getMessage());
}

try {
    $task = $tasks->getTask(3);
    echo "\n" . $task->__toString();
} catch (AuthException|FiledException $e) {
    echo("\n" . $e->getMessage());
}

try {
    $delete = $tasks->deleteTask(1);
    echo "\n" . ($delete ? "delete success" : "delete failed");
} catch (AuthException|FiledException $e) {
    echo("\n" . $e->getMessage());
}

$subscribe = $chatNio->Subscribe();
try {
    echo "\n" . "isSubscribed: " . ($subscribe->isSubscribed() ? "true" : "false");
    echo "\n" . "expired: " . $subscribe->expired();
    $buy = $subscribe->buy(1, new SubLevel(SubLevel::Standard));
    echo "\n" . ($buy ? "buy success" : "buy failed");
} catch (AuthException|FiledException|BuyException $e) {
    echo("\n" . $e->getMessage());
}

// 同步调用
require_once __DIR__ . "/data/ChatAsync.php";
$async = new ChatAsync(new Token($key));
$async->sendMessage("写一段PHP调用WebSocket的示例");
echo "\n" . "async send success: " . $async->getMessages();

// 异步调用
require_once __DIR__ . "/data/ChatSync.php";
$sync = new ChatSync(new Token($key), new class extends CustomSync
{

    function onMessage(MessageSegment $message)
    {
        echo "\n" . $message->getMessage();
    }

    function onError(Exception $exception)
    {
        throw new FiledException($exception->getMessage());
    }
});

$sync->sendMessage("写一段PHP调用WebSocket的示例");
echo "\n" . "sync send success: " . $sync->getMessages();
```