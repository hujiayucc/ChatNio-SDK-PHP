<?php

require_once "ChatNio.php";

use com\hujiayucc\chatnio\ChatNio;
use com\hujiayucc\chatnio\exception\AuthException;
use com\hujiayucc\chatnio\exception\BuyException;
use com\hujiayucc\chatnio\exception\FiledException;

$chatNio = new ChatNio("sk-key");

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