<?php

namespace PoweredByStuff\FlarumPostSubscriptions\Notification;

use Flarum\Post\Post;
use Flarum\User\User;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;

class PostRevisedNotification implements BlueprintInterface, MailableInterface
{
    public $post;

    public $actor;

    public function __construct(Post $post, User $actor)
    {
        $this->post = $post;
        $this->actor = $actor;
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
        return $this->actor;
    }

    public static function getSubjectModel()
    {
        return Post::class;
    }

    public function getEmailView()
    {
        return ['text' => 'flarum-post-subscriptions::emails.postRevised'];
    }

    public function getEmailSubject()
    {
        return '[Post Updated] '.$this->post->discussion->title;
    }
}
