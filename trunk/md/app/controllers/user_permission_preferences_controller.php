<?php
class UserPermissionPreferencesController extends AppController
{
    var $name = 'UserPermissionPreferences';
    var $uses = array(
        'UserPermissionPreference',
        'UserPreferenceCategory',
        'PrivacyType'
    );
    function edit($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = $this->Auth->user('id');
        }
        $this->pageTitle = __l('Edit Permission Preferences');
        if (!empty($this->data)) {
            if (empty($this->data['User']['id'])) {
                $this->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserPermissionPreference->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->data['User']['id']
                ) ,
                'contain' => array(
                    'UserPermissionPreference' => array(
                        'fields' => array(
                            'UserPermissionPreference.id'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            $user_id = $user['User']['id'];
            if (!empty($user['UserPermissionPreference'])) {
                $this->data['UserPermissionPreference']['id'] = $user['UserPermissionPreference']['id'];
                $this->data['UserPermissionPreference']['user_id'] = $this->data['User']['id'];
            }
            if ($this->UserPermissionPreference->save($this->data)) {
                $this->Session->setFlash(__l('Permissions are updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Permissions could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserPermissionPreference->find('first', array(
                'conditions' => array(
                    'UserPermissionPreference.user_id' => $user_id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (empty($this->data)) {
                $this->data['UserPermissionPreference']['user_id'] = $user_id;
                $this->UserPermissionPreference->create();
                $this->UserPermissionPreference->save($this->data);
                $this->redirect(array(
                    'controller' => 'user_permission_preferences',
                    'action' => 'edit',
                    $user_id,
                    'admin' => false
                ));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['User']['username'];
        $userPreferenceCategories = $this->UserPreferenceCategory->find('all');
        $privacyTypes = $this->PrivacyType->find('list');
        if (!Configure::read('friend.is_enabled')) {
            unset($privacyTypes[ConstPrivacySetting::Friends]);
        }
        if ($this->data['User']['user_type_id'] == ConstUserTypes::Company && !Configure::read('user.is_company_actas_normal_user')) {
            unset($privacyTypes[ConstPrivacySetting::Friends]);		
		}
        if ($this->data['User']['user_type_id'] == ConstUserTypes::Company) {
            unset($this->data['UserPermissionPreference']['Profile-is_show_gender']);
            unset($this->data['UserPermissionPreference']['Profile-is_show_name']);
        }
        if ($this->data['User']['user_type_id'] == ConstUserTypes::Company && !Configure::read('user.is_company_actas_normal_user')) {
            unset($this->data['UserPermissionPreference']['Profile-is_allow_comment_add']);
            unset($this->data['UserPermissionPreference']['Profile-is_receive_email_for_new_comment']);
        }
        $this->set(compact('userPreferenceCategories', 'privacyTypes'));
        $this->data['User']['id'] = $user_id;
    }
    function admin_edit($user_id)
    {
        $this->setAction('edit', $user_id);
    }
}
?>