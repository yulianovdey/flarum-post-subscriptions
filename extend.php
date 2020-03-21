<?php

use Flarum\Extend;
use PoweredByStuff\FlarumPostSubscriptions\Listener;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),
    (new Extend\Locales(__DIR__.'/locale')),
    function (Dispatcher $events) {
        $events->subscribe(Listener\AddPostSubscriptionRelationship::class);
        $events->subscribe(Listener\SaveSubscriptionsToDatabase::class);
    },
];
