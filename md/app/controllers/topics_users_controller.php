<?php
class TopicsUsersController extends AppController
{
    var $name = 'TopicsUsers';
    function add($topic_id = null)
    {
        $this->data['TopicsUser']['topic_id'] = $topic_id;
        $this->data['TopicsUser']['user_id'] = $this->Auth->user('id');
        if (!empty($this->data)) {
            $this->TopicsUser->create();
            if ($this->TopicsUser->save($this->data)) {
                $this->Session->setFlash(__l('You are now following this topic') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'topic_discussions',
                    'action' => 'index',
                    $topic_id
                ));
            }
        }
    }
    function delete($topic_id = null)
    {
        if (is_null($topic_id)) {
            $this->cakeError('error404');
        }
        if ($this->TopicsUser->deleteAll(array(
            'TopicsUser.topic_id' => $topic_id,
            'TopicsUser.user_id' => $this->Auth->user('id')
        ))) {
            $this->Session->setFlash(__l('You are no longer following this topic') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'topic_discussions',
                'action' => 'index',
                $topic_id
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>