<?php

use Flarum\Database\Migration;

return Migration::addColumns('post_user', [
    'subscription' => ['enum', 'allowed' => ['follow'], 'nullable' => true]
]);
