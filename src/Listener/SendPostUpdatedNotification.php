<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Listener;

use Flarum\Post\Event\Saving;
use PoweredByStuff\FlarumPostSubscriptions\Notification\PostUpdatedNotification;
use Flarum\Notification\NotificationSyncer;
use PoweredByStuff\FlarumPostSubscriptions\Post\UserState;

class SendPostUpdatedNotification
{
    protected $notifications;

    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle(Saving $event)
    {
        $post = $event->post;

        $subscriptions = $event->post->hasMany(UserState::class, 'post_id')
                ->where('user_id', '<>', $event->actor->id)
                ->where('subscription', 'follow')
                ->with('user')
                ->get();

        $this->notifications->sync(
            new PostUpdatedNotification($event->post, $event->post->user),
            $subscriptions->pluck('user')->all()
        );
    }
}
