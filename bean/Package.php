<?php

namespace com\hujiayucc\chatnio\bean;

/** 礼包 */
class Package
{
    private bool $cert;
    private bool $teenager;

    /** 礼包 */
    public function __construct(bool $cert, bool $teenager)
    {
        $this->cert = $cert;
        $this->teenager = $teenager;
    }

    /**
     * @return bool 实名认证即可获得 50 Nio 点数
     */
    public function isCert(): bool
    {
        return $this->cert;
    }

    /**
     * @return bool 未成年（学生）可额外获得 150 Nio 点数
     */
    public function isTeenager(): bool
    {
        return $this->teenager;
    }
}