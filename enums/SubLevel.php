<?php

namespace com\hujiayucc\chatnio\enums;

/** 订阅级别 */
class SubLevel
{
    /** 普通用户 */
    const Normal = 0;
    /** 基础版 */
    const Basic = 1;
    /** 标准版 */
    const Standard = 2;
    /** 专业版 */
    const Professional = 3;

    private int $level;

    /**
     * 订阅级别
     * @param int $level 例如：SubLevel::Standard
     */
    public function __construct(int $level)
    {
        $this->level = $level;
    }

    /**
     * 订阅级别
     * @return int 订阅级别
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}


