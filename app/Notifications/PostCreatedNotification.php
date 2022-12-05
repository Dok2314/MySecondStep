<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCreatedNotification extends Notification
{
    use Queueable;

    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title'     => $this->post->title,
            'user_name' => $this->post->user->name,
            'post'      => $this->post->post
        ];
    }
}
