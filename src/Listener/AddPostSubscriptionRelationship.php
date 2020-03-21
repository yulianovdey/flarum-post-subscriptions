<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Listener;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Post\Post;
use Illuminate\Contracts\Events\Dispatcher;
use PoweredByStuff\FlarumPostSubscriptions\Post\UserState;

class AddPostSubscriptionRelationship
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'addSubscriptionAttribute']);
    }

    public function addSubscriptionAttribute(Serializing $event)
    {
        if ($event->isSerializer(PostSerializer::class)) {
            $subscribed = $event->model->hasMany(UserState::class, 'post_id')
                ->where('user_id', $event->actor->id)
                ->where('subscription', 'follow')
                ->exists();

            $event->attributes['subscription'] = $subscribed ? 'follow' : null;
        }
    }
}
