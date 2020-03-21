import { extend } from 'flarum/extend';
import app from 'flarum/app';
import Post from 'flarum/models/Post';
import Model from 'flarum/Model';
import NotificationGrid from 'flarum/components/NotificationGrid';
import PostUpdatedNotification from './PostUpdatedNotification';

import addSubscribeAction from './addSubscribeAction';
import addSubscribedIndicator from './addSubscribedIndicator';

app.initializers.add('flarum-post-subscriptions', () => {
  Post.prototype.subscription = Model.attribute('subscription');
  app.notificationComponents.postUpdated = PostUpdatedNotification;

  addSubscribeAction();
  addSubscribedIndicator();

  extend(NotificationGrid.prototype, 'notificationTypes', function (items) {
    items.add('postUpdated', {
      name: 'postUpdated',
      icon: 'far fa-star',
      label: app.translator.trans('flarum-post-subscriptions.forum.settings.notify_post_updated_label')
    });
  });
});
