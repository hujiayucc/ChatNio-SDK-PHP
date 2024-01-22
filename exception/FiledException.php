<?php

namespace com\hujiayucc\chatnio\exception;

use Exception;

/** 字段错误 */
class FiledException extends Exception
{
    /**
     * 字段错误
     * @param string $message 错误信息
     */
    public function __construct(string $message) {
        parent::__construct($message);
    }
}