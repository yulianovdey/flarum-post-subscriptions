<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Post;

use Flarum\Post\Post;
use Flarum\Database\AbstractModel;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class UserState extends AbstractModel
{
    protected $table = 'post_user';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('post_id', $this->post_id)
              ->where('user_id', $this->user_id);

        return $query;
    }
}
