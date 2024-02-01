<?php

namespace com\hujiayucc\chatnio\exception;

use Exception;

/** 购买错误 */
class BuyException extends Exception
{
    /**
     * 购买错误
     * @param string $message 错误原因
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}