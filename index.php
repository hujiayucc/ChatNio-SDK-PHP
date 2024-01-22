<?php

require_once "ChatNio.php";

use com\hujiayucc\chatnio\ChatNio;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\FiledException;

$chatNio = new ChatNio("sk-key");

try {
    echo $chatNio->Pets()->getQuota();
} catch (AuthException|FiledException $e) {
    die($e->getMessage());
}