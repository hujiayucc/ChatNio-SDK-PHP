<?php

namespace com\hujiayucc\chatnio\utils;

require_once __DIR__ . "/../bean/MessageSegment.php";

use com\hujiayucc\chatnio\bean\MessageSegment;
use Exception;

interface IWebSocketConnection
{
    /** 消息接收回调 */
    function onMessage(MessageSegment $message);
    /** 错误异常回调 */
    function onError(Exception $exception);
}