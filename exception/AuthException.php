<?php
namespace com\hujiayucc\chatnio\exception;

use Exception;

/** 认证失败 */
class AuthException extends Exception
{
    /**
     * 认证失败
     * @param string $message 失败原因
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

