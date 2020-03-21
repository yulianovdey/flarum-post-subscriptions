import { extend } from 'flarum/extend';
import app from 'flarum/app';
import Button from 'flarum/components/Button';
import CommentPost from 'flarum/components/CommentPost';

export default function() {
  extend(CommentPost.prototype, 'actionItems', function(items) {
    const post = this.props.post;

    if (post.isHidden() || !app.session.user || post.user().id() === app.session.user.id()) return;

    let isSubscribed = post.subscription() === 'follow';

    let translationKey;
    if (isSubscribed) {
      translationKey = 'flarum-post-subscriptions.forum.post.unsubscribe_link';
    } else {
      translationKey = 'flarum-post-subscriptions.forum.post.subscribe_link';
    }

    items.add('subscribe',
      Button.component({
        children: app.translator.trans(translationKey),
        className: 'Button Button--link',
        onclick: () => {
          post.save({subscription: !isSubscribed ? 'follow' : null});
        }
      })
    );
  });
}
