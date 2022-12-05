<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User;
use App\Services\Helpers\Telegram;

class SendTelegrammMessageWhenUserRegistered
{
    protected Telegram $telegram;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $userCount = User::all()->count();

        $this->telegram->sendMessage(config('bots.telegram_bot.chat_id'), (string)view('events.userRegistered', compact('event','userCount')));
    }
}
