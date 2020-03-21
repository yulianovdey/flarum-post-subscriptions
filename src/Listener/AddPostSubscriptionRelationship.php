<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Listener;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Event\GetModelRelationship;
use Flarum\Post\Post;
use Illuminate\Contracts\Events\Dispatcher;
use PoweredByStuff\FlarumPostSubscriptions\Post\UserState;

class AddPostSubscriptionRelationship
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(GetModelRelationship::class, [$this, 'getModelRelationship']);
        $events->listen(Serializing::class, [$this, 'addSubscriptionAttribute']);
    }

    public function getModelRelationship(GetModelRelationship $event)
    {
        if ($event->isRelationship(Post::class, 'subscription')) {
            return $event->model->hasOne(
                UserState::class,
                'post_id'
            );
        }
    }

    public function addSubscriptionAttribute(Serializing $event)
    {
        if ($event->isSerializer(PostSerializer::class)) {
            $state = $event->model->subscription()->where('user_id', $event->actor->id)->first();
            $event->attributes['subscription'] = $state ? $state->subscription : null;
        }
    }
}
