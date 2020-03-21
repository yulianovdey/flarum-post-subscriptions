import Notification from 'flarum/components/Notification';
import { truncate } from 'flarum/utils/string';

export default class PostUpdatedNotification extends Notification {
  icon() {
    return 'far fa-star';
  }

  href() {
    return app.route.post(this.props.notification.subject());
  }

  content() {
    return app.translator.trans(
      'flarum-post-subscriptions.forum.notifications.post_updated_text',
      { user: this.props.notification.fromUser() }
    );
  }

  excerpt() {
    return truncate(this.props.notification.subject().contentPlain(), 200);
  }
}
