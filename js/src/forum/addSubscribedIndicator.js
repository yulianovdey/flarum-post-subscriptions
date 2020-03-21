import app from 'flarum/app';
import { extend } from 'flarum/extend';
import CommentPost from 'flarum/components/CommentPost';
import icon from 'flarum/helpers/icon';

export default function() {
  extend(CommentPost.prototype, 'footerItems', function(items) {
    const { post } = this.props;

    if (post.subscription() === 'follow') {
      items.add('subscribed', (
        <div>
          {icon('fa fa-star')} {app.translator.trans('flarum-post-subscriptions.forum.post.subscribed_indicator')}
        </div>
      ));
    }
  });
}
