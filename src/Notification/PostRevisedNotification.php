<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Notification;

use Flarum\Post\Post;
use Flarum\User\User;
use Flarum\Notification\Blueprint\BlueprintInterface;

class PostRevisedNotification implements BlueprintInterface
{
    protected $post;

    protected $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function getSubject()
    {
        return $this->post;
    }

    public function getData()
    {
        return substr(md5($this->post->content), 0, 10);
    }

    public static function getType()
    {
        return 'postRevised';
    }

    public function getFromUser()
    {
        return $this->user;
    }

    public static function getSubjectModel()
    {
        return Post::class;
    }
}
