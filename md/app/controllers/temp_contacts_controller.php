<?php
class TempContactsController extends AppController
{
    var $name = 'TempContacts';
    var $uses = array(
        'TempContact',
        'User',
    );
    function beforeFilter()
    {
        if (!$this->User->isAllowed($this->Auth->user('user_type_id'))) {
            //$this->cakeError('error404');

        }
        $this->Security->disabledFields = array(
            'TempContact.send_contact',
            'TempContact.temp_contact',
            'UserFriend.invite_all'
        );
        parent::beforeFilter();
    }
    function index($member = null, $contacts_source = null, $deal_invite_check = null)
    {
        $this->pageTitle = __l('User Friends');
        $this->paginate = array(
            'conditions' => array(
                'TempContact.user_id' => $this->Auth->user('id') ,
                'TempContact.is_member' => $member
            ) ,
            'contain' => array(
                'ContactUser' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.dir',
                            'UserAvatar.filename'
                        )
                    ) ,
                    'fields' => array(
                        'ContactUser.user_type_id',
                        'ContactUser.username',
                        'ContactUser.id',
                        'ContactUser.email',
                    )
                )
            ) ,
            'limit' => 10,
            'recursive' => 1
        );
        $this->set('invite_friend_options', $this->TempContact->invite_friend_options);
        $this->set('add_friend_options', $this->TempContact->add_friend_options);
        $this->set('exist_friend_options', $this->TempContact->exist_friend_options);
        $this->set('tempContacts', $this->paginate());
        $this->set('member', $member);
        $this->set('contacts_source', $contacts_source);
        $this->set('deal_slug', $deal_invite_check);
    }
}
?>