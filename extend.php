<?php

use Flarum\Extend;
use PoweredByStuff\FlarumPostSubscriptions\Listener;
use PoweredByStuff\FlarumPostSubscriptions\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Post\Event\Revised as PostRevised;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),
    (new Extend\Locales(__DIR__.'/locale')),
    function (Dispatcher $events) {
        $events->subscribe(Listener\AddPostSubscriptionRelationship::class);
        $events->subscribe(Listener\SaveSubscriptionsToDatabase::class);

        $events->listen(ConfigureNotificationTypes::class, function (ConfigureNotificationTypes $event) {
            $event->add(Notification\PostRevisedNotification::class, PostSerializer::class, ['alert']);
        });

        $events->listen(PostRevised::class, Listener\SendPostRevisedNotification::class);
    },
];
