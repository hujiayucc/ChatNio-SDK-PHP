<?php

namespace com\hujiayucc\chatnio\utils;

require_once __DIR__ . "/../bean/MessageSegment.php";
require_once __DIR__ . "/../bean/Token.php";
require_once __DIR__ . "/../ChatNio.php";
require_once __DIR__ . "/IWebSocketConnection.php";
# require_once __DIR__ . "/../vendor/autoload.php";

use com\hujiayucc\chatnio\bean\MessageSegment;
use com\hujiayucc\chatnio\bean\Token;
use com\hujiayucc\chatnio\ChatNio;
use WebSocket\BadOpcodeException;
use WebSocket\Client;

abstract class WsClient extends Client implements IWebSocketConnection
{
    /**
     * @param Token $token 对话Token
     */
    public function __construct(Token $token)
    {
        parent::__construct(
            $this->getPath(),
            array(
                'timeout' => 60
            )
        );
        try {
            $this->send($token->__toString());
        } catch (BadOpcodeException $e) {
            $this->onError($e);
        }
    }

    private function getBody(array $body): string
    {
        return json_encode($body);
    }

    /**
     * @param string $message 消息内容
     * @param string $model 模型 默认 gpt-3.5-turbo-0613
     * @param bool $enableWeb 是否开启联网 默认关闭
     */
    public function sendMessage(string $message, string $model = "gpt-3.5-turbo-0613", bool $enableWeb = false)
    {
        $body = $this->getBody(
            array(
                'type'      => 'chat',
                'message'   => $message,
                'model'     => $model,
                'web' => $enableWeb
            )
        );
        $this->text($body);
        $json = json_decode($this->receive());
        while (!$json->end) {
            $this->onMessage(new MessageSegment($this->receive()));
            $json = json_decode($this->receive());
        }
    }

    private function getPath(): string
    {
        return str_replace("http", "ws", ChatNio::$API . "/chat");
    }
}