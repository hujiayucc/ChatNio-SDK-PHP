<?php

namespace com\hujiayucc\chatnio\utils;

use com\hujiayucc\chatnio\bean\MessageSegment;

interface IWebSocketConnection
{
    /** 消息接收回调 */
    function onMessage(MessageSegment $message);
    /** 错误异常回调 */
    function onError(\Exception $exception);
}