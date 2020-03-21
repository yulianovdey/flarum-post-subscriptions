import { extend } from 'flarum/extend';
import app from 'flarum/app';
import Post from 'flarum/models/Post';
import Model from 'flarum/Model';
import NotificationGrid from 'flarum/components/NotificationGrid';
import PostRevisedNotification from './PostRevisedNotification';

import addSubscribeAction from './addSubscribeAction';
import addSubscribedIndicator from './addSubscribedIndicator';

app.initializers.add('flarum-post-subscriptions', () => {
  Post.prototype.subscription = Model.attribute('subscription');
  app.notificationComponents.postRevised = PostRevisedNotification;

  addSubscribeAction();
  addSubscribedIndicator();

  extend(NotificationGrid.prototype, 'notificationTypes', function (items) {
    items.add('postRevised', {
      name: 'postRevised',
      icon: 'far fa-star',
      label: app.translator.trans('flarum-post-subscriptions.forum.settings.notify_post_revised_label')
    });
  });
});
