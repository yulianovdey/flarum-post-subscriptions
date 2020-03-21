import app from 'flarum/app';
import Post from 'flarum/models/Post';
import Model from 'flarum/Model';

import addSubscribeAction from './addSubscribeAction';
import addSubscribedIndicator from './addSubscribedIndicator';

app.initializers.add('flarum-post-subscriptions', () => {
  Post.prototype.subscription = Model.attribute('subscription');

  addSubscribeAction();
  addSubscribedIndicator();
});
