<?php

require_once "ChatNio.php";

// 下面两个可以删掉，只是方便导入秘钥
global $key;
include "config.php";

use com\hujiayucc\chatnio\ChatNio;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\BuyException;
use com\hujiayucc\chatnio\exception\FiledException;

$chatNio = new ChatNio($key);

try {
    echo $chatNio->Pets()->getQuota();
} catch (AuthException|FiledException $e) {
    die($e->getMessage());
}

try {
    echo "\n" . ($chatNio->Pets()->buy(1) ? "true" : "false");
    echo "\n" . $chatNio->Pets()->getQuota();
} catch (AuthException|BuyException|FiledException $e) {
    die($e->getMessage());
}

try {
    $package = $chatNio->Pets()->Package();
    echo "\ncert: " . ($package->isCert() ? "true" : "false");
    echo "\nTeenager: " . ($package->isTeenager() ? "true" : "false");
} catch (FiledException|AuthException $e) {
    die($e->getMessage());
}

try {
    $tasks = $chatNio->Tasks();
    $taskList = $tasks->getTaskList();
    foreach ($taskList as $task) {
        echo "\n" . $task->__toString();
    }
} catch (AuthException|FiledException $e) {
    die($e->getMessage());
}

try {
    $task = $tasks->getTask(3);
    echo "\n" . $task->__toString();
} catch (AuthException|FiledException $e) {
    die($e->getMessage());
}

try {
    $delete = $tasks->deleteTask(1);
    echo "\n" . ($delete ? "delete success" : "delete failed");
} catch (AuthException|FiledException $e) {
    die($e->getMessage());
}