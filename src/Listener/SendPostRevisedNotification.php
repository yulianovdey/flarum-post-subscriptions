<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Listener;

use Flarum\Post\Event\Revised;
use PoweredByStuff\FlarumPostSubscriptions\Notification\PostRevisedNotification;
use Flarum\Notification\NotificationSyncer;
use PoweredByStuff\FlarumPostSubscriptions\Post\UserState;

class SendPostRevisedNotification
{
    protected $notifications;

    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(Revised $event)
    {
        $post = $event->post;

        if (!$post->user) {
            return;
        }

        $subscriptions = $post->hasMany(UserState::class, 'post_id')
                ->where('user_id', '<>', $event->actor->id)
                ->where('subscription', 'follow')
                ->with('user')
                ->get();

        $this->notifications->sync(
            new PostRevisedNotification($post, $post->user),
            $subscriptions->pluck('user')->all()
        );
    }
}
