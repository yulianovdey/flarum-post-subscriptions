Hey {!! $user->display_name !!}!

{!! $blueprint->actor->display_name !!} updated a post you're following in "{!! $blueprint->post->discussion->title !!}"

To view the new activity, check out the following link:
{!! app()->url() !!}/d/{!! $blueprint->post->discussion_id !!}/{!! $blueprint->post->number !!}

---

{!! $blueprint->post->content !!}

---
