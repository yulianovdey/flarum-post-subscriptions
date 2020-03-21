<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Listener;

use PoweredByStuff\FlarumPostSubscriptions\Event;

use Flarum\Post\Event\Saving;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\User\AssertPermissionTrait;
use PoweredByStuff\FlarumPostSubscriptions\Post\UserState;

class SaveSubscriptionsToDatabase
{
    use AssertPermissionTrait;

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'whenPostIsSaving']);
        $events->listen(Deleted::class, [$this, 'whenPostIsDeleted']);
    }

    public function whenPostIsSaving(Saving $event)
    {
        $post = $event->post;
        $data = $event->data;

        if (array_key_exists('subscription', $data['attributes'])) {
            $actor = $event->actor;
            $subscription = $data['attributes']['subscription'];

            $this->assertRegistered($actor);

            $state = $post->hasOne(UserState::class, 'post_id')->where('user_id', $actor->id)->first();

            if (!$state) {
                $state = new UserState;
                $state->post_id = $post->id;
                $state->user_id = $actor->id;
            }

            if ($subscription !== 'follow') {
                $subscription = null;
            }

            $state->subscription = $subscription;
            $state->save();
        }
    }
}
