<?php
class UserProfilesController extends AppController
{
    var $name = 'UserProfiles';
    var $uses = array(
        'UserProfile',
        'Attachment',
        'EmailTemplate'
    );
    var $components = array(
        'Email'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id'
        );
        parent::beforeFilter();
    }
    function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->data)) {
            if (empty($this->data['User']['id'])) {
                $this->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.language_id',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->data['UserProfile']['user_id'] = $this->data['User']['id'];
            if (!empty($this->data['UserAvatar']['filename']['name'])) {
                $this->data['UserAvatar']['filename']['type'] = get_mime($this->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->data);
            }
            $this->UserProfile->set($this->data);
            $this->UserProfile->User->set($this->data);
            $this->UserProfile->State->set($this->data);
            $this->UserProfile->City->set($this->data);
            $ini_upload_error = 1;
            if (!empty($this->data['UserAvatar']['filename']) && $this->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() &$this->UserProfile->validates() &$this->UserProfile->User->UserAvatar->validates() &$this->UserProfile->City->validates() &$this->UserProfile->State->validates() && $ini_upload_error) {
                $this->data['UserProfile']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->UserProfile->City->findOrSaveAndGetId($this->data['City']['City']['name']);
                $this->data['UserProfile']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->UserProfile->State->findOrSaveAndGetId($this->data['State']['name']);
                if ($this->UserProfile->save($this->data)) {
                    $this->UserProfile->User->save($this->data['User']);
                    if (!empty($this->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->data['UserAvatar']['foreign_id'] = $this->data['User']['id'];
                        $this->Attachment->save($this->data['UserAvatar']);
                    }
                    if ($this->data['UserProfile']['language_id'] != $user['UserProfile']['language_id']) {
                        $this->UserProfile->User->UserLogin->updateUserLanguage();
                    }
                }
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
					$language_code = $this->UserProfile->getUserLanguageIso($user['User']['id']);
					$email = $this->EmailTemplate->selectTemplate('Admin User Edit', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->UserProfile->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##USERNAME##' => $user['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                    );
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                }
            } else {
                if (!empty($this->data['UserAvatar']['filename']) && $this->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->data['User'] = array_merge($user['User'], $this->data['User']);
                $this->data['UserAvatar'] = $user['UserAvatar'];
            }
            //Setting ajax layout when submitting through iframe with jquery ajax form plugin
            if (!empty($this->params['form']['is_iframe_submit'])) {
                $this->layout = 'ajax';
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.user_type_id !=' => ConstUserTypes::Company
                ) ,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                    'User.email',
                    'User.user_type_id',
                    'User.user_login_count',
                    'User.user_view_count',
                    'User.is_active',
                    'User.is_email_confirmed',
					'User.fb_user_id',
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.first_name',
                            'UserProfile.last_name',
                            'UserProfile.middle_name',
                            'UserProfile.gender_id',
                            'UserProfile.about_me',
                            'UserProfile.address',
                            'UserProfile.country_id',
                            'UserProfile.state_id',
                            'UserProfile.city_id',
                            'UserProfile.zip_code',
                            'UserProfile.dob',
                            'UserProfile.language_id',
                            'UserProfile.paypal_account',
                            'UserProfile.user_id',
                            'UserProfile.user_education_id',
                            'UserProfile.user_employment_id',
                            'UserProfile.user_incomerange_id',
                            'UserProfile.user_relationship_id',
                            'UserProfile.own_home',
                            'UserProfile.have_children',
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            $this->data['UserProfile']['user_id'] = $user_id;
            if (!empty($this->data['UserProfile']['City'])) {
                $this->data['City']['City']['name'] = $this->data['City']['name'] = $this->data['City']['name'] = $this->data['UserProfile']['City']['name'];
            }
            if (!empty($this->data['UserProfile']['State']['name'])) {
                $this->data['State']['name'] = $this->data['UserProfile']['State']['name'];
            }
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
        $userEducations = $this->UserProfile->UserEducation->find('list',array('fields' => array('UserEducation.education')));		
        $userEmployments = $this->UserProfile->UserEmployment->find('list',array('fields' => array('UserEmployment.employment')));
        $userIncomeranges = $this->UserProfile->UserIncomeRange->find('list',array('fields' => array('UserIncomeRange.income')));
        $userRelationships = $this->UserProfile->UserRelationship->find('list',array('fields' => array('UserRelationship.relationship')));
        $countries = $this->UserProfile->Country->find('list', array(
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        //get languages
        //$languages = $this->UserProfile->Language->Translation->get_languages();
        $languageLists = $this->UserProfile->Language->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0
            ) ,
            'fields' => array(
                'DISTINCT(Translation.language_id)',
                'Language.name',
                'Language.id'
            ) ,
            'order' => array(
                'Language.name' => 'ASC'
            )
        ));
        $languages = array();
        if (!empty($languageLists)) {
            foreach($languageLists as $languageList) {
                $languages[$languageList['Language']['id']] = $languageList['Language']['name'];
            }
        }
        //end
        $this->set(compact('genders', 'userEducations', 'userEmployments', 'userIncomeranges', 'userRelationships', 'countries', 'languages'));
    }
    function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->data)) {
            $this->cakeError('error404');
        }
        $this->setAction('edit', $id);
    }
    function admin_user_account($user_id = null)
    {
        if (is_null($user_id)) {
            $this->cakeError('error404');
        }
        $this->setAction('my_account', $user_id);
    }
    function my_account($user_id = null)
    {
        if (is_null($user_id)) {
            $this->cakeError('error404');
        }
        $this->set('user_id', $user_id);
    }
}
?>