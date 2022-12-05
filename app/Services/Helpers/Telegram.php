<?php

namespace App\Services\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    const URL   = 'https://api.tlgr.org/bot';

    protected array $bot;
    protected Http $http;

    public function __construct(Http $http, $bot)
    {
        $this->http = $http;
        $this->bot  = $bot;
    }

    public function sendMessage($chatId, $message)
    {
        return $this->http::post(self::URL . $this->bot['token'] . '/sendMessage', [
            'chat_id'    => $chatId,
            'text'       => $message,
            'parse_mode' => 'html'
        ]);
    }

    public function editMessage($chatId, $message, $messageId)
    {
        return $this->http::post(self::URL . $this->bot['token'] . '/editMessageText', [
            'chat_id'      => $chatId,
            'text'         => $message,
            'parse_mode'   => 'html',
            'message_id'   => $messageId
        ]);
    }

    public function sendDocument($chatId, $message, $reply_id = null)
    {
        return $this->http::attach('document', Storage::disk('images')->url('/user/1669747145.jpg'), 'новый_нигер.jpg')
            ->post(self::URL . $this->bot['token'] . '/sendDocument', [
            'chat_id'             => $chatId,
            'reply_to_message_id' => $reply_id
        ]);
    }

    public function sendButtons($chatId, $message, $buttons)
    {
        return $this->http::post(self::URL . $this->bot['token'] . '/sendMessage', [
            'chat_id'      => $chatId,
            'text'         => $message,
            'parse_mode'   => 'html',
            'reply_markup' => $buttons
        ]);
    }

    public function editButtons($chatId, $message, $buttons, $messageId)
    {
        return $this->http::post(self::URL . $this->bot['token'] . '/editMessageText', [
            'chat_id'      => $chatId,
            'text'         => $message,
            'parse_mode'   => 'html',
            'reply_markup' => $buttons,
            'message_id'   => $messageId
        ]);
    }
}
