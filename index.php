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