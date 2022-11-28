<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\ChatChannel;

Broadcast::channel('chat', ChatChannel::class);
