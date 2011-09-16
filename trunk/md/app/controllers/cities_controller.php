<?php
class CitiesController extends AppController
{
    var $name = 'Cities';
    var $uses = array(
        'City',
        'Attachment'
    );
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment'
        );
        parent::beforeFilter();
    }
    function index()
    {
        $this->paginate = array(
            'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'fields' => array(
                'City.name',
                'City.slug',
                'City.active_deal_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'limit' => 200,
            'recursive' => -1
        );		
        // <-- For iPhone App code 
		if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $this->paginate(): $this->viewVars['iphone_response']);
        }else{
			$this->set('cities', $this->paginate());
		}
		// For iPhone App code -->
    }
    function admin_index()
    {
		$this->_redirectGET2Named(array(
            'q',
			'filter_id',
        ));
        $this->disableCache();
        $this->pageTitle = __l('Cities');
        $conditions = array();
		if (!empty($this->data['City']['filter_id'])) {
            $this->params['named']['filter_id'] = $this->data['City']['filter_id'];
        }
        $this->City->validate = array();
        if (!empty($this->params['named']['filter_id'])) {
            if ($this->params['named']['filter_id'] == ConstMoreAction::Active) {
                $this->pageTitle.= __l(' - Approved');
                $conditions[$this->modelClass . '.is_approved'] = 1;
            } else if ($this->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $this->pageTitle.= __l(' - Disapproved');
                $conditions[$this->modelClass . '.is_approved'] = 0;
            }
        }
		
        if (empty($this->data['City']['q']) && !empty($this->params['named']['q'])) {
            $this->data['City']['q'] = $this->params['named']['q'];
        }
        if (isset($this->data['City']['q']) && !empty($this->data['City']['q'])) {
            $this->params['named']['q'] = $this->data['City']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->data['City']['q']);
        }
        $this->City->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'City.id',
                'City.name',
                'City.latitude',
                'City.longitude',
                'City.county',
                'City.code',
                'City.slug',
                'City.is_approved',
                'State.name',
                'Country.name',
                'Language.name',
                'City.active_deal_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        );
        if (isset($this->data['City']['q'])) {
            $this->paginate['search'] = $this->data['City']['q'];
        }
        $this->set('cities', $this->paginate());
        $this->set('pending', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved = ' => 0
            )
        )));
        $this->set('approved', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved = ' => 1
            )
        )));
        $filters = $this->City->isFilterOptions;
        $moreActions = $this->City->moreActions;
        $this->set(compact('filters', 'moreActions'));
        $this->set('pageTitle', $this->pageTitle);
    }
    function admin_update_twitter($id = null)
    {
        $this->pageTitle = __l('Update Twitter');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        // Twitter Login //
        App::import('Component', 'OauthConsumer');
        $this->OauthConsumer = &new OauthConsumerComponent();
        $requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'http://twitter.com/oauth/request_token');
        $this->Session->write('requestToken', $requestToken);
        $this->Session->write('twitter_city_id', $id);
        $this->redirect('http://twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit City');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $defaultCity = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => Configure::read('site.city')
            ) ,
            'fields' => array(
                'City.id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($defaultCity) && $id == $defaultCity['City']['id']) {
            $this->set('id_default_city', true);
        }        
        if (!empty($this->data)) {
			if (!empty($this->data['Attachment']['filename']['name'])) {
				$this->City->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
			}
            if (!empty($this->data['OldAttachment']['id'])) {
                $this->City->Attachment->del($this->data['Attachment']['id']);
            }
            if (!empty($this->data['Attachment']['filename']['name'])) {
                $this->data['Attachment']['filename']['type'] = get_mime($this->data['Attachment']['filename']['tmp_name']);
            }
            if (!empty($this->data['Attachment']['filename']['name']) || (!Configure::read('image.file.allowEmpty') && empty($this->data['Attachment']['id']))) {
                $this->data['Attachment']['class'] = 'City';
                $this->City->Attachment->create();
                $this->City->Attachment->set($this->data);
            }
            $this->City->set($this->data);
            $ini_upload_error = 1;
            if ($this->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->City->validates() && (empty($this->data['Attachment']['filename']['name']) || $this->City->Attachment->validates()) && $ini_upload_error) {
                $this->City->save($this->data);
                $foreign_id = $this->data['City']['id'];
                $attach = $this->City->Attachment->find('first', array(
                    'conditions' => array(
                        'Attachment.foreign_id = ' => $foreign_id,
                        'Attachment.class = ' => 'City'
                    ) ,
                    'fields' => array(
                        'Attachment.id'
                    ) ,
                    'recursive' => -1,
                ));
                if (!(empty($this->data['Attachment']['filename']['name']))) {
                    $this->data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->data['Attachment']['class'] = $this->modelClass;
                    $this->data['Attachment']['description'] = 'City Image';
                    $this->data['Attachment']['id'] = $attach['Attachment']['id'];
                    $this->data['Attachment']['foreign_id'] = $this->data['City']['id'];
                    $data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->City->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
                    $this->City->Attachment->set($data);
                    if ($this->City->Attachment->validates()) {
                        $this->City->Attachment->save($this->data['Attachment']);
                    }
                }
                $this->Session->setFlash(__l('City has been updated') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('City could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->City->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['City']['name'];
        $countries = $this->City->Country->find('list');
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved' => 1
            )
        ));
        //get languages
        App::import('Model', 'Translation');
        $this->Translation = new Translation();
        $languageLists = $this->City->Language->Translation->find('all', array(
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
        $this->set(compact('countries', 'states', 'languages'));
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add City');
        
        if (!empty($this->data)) {
			if (!empty($this->data['Attachment']['filename']['name'])) {
                $this->data['Attachment']['filename']['type'] = get_mime($this->data['Attachment']['filename']['tmp_name']);
				$this->City->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
			}
            if (!empty($this->data['Attachment']['filename']['name']) || (!Configure::read('image.file.allowEmpty') && empty($this->data['Attachment']['id']))) {
                $this->data['Attachment']['class'] = 'City';
                $this->City->Attachment->set($this->data);
            }
            $this->City->set($this->data);
            $ini_upload_error = 1;
            if ($this->data['Attachment']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->City->validates() && (empty($this->data['Attachment']['filename']['name']) || $this->City->Attachment->validates()) && $ini_upload_error) {
                $this->data['City']['is_approved'] = 1;
                $this->City->create();
                if ($this->City->save($this->data)) {
                    $this->data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->data['Attachment']['class'] = $this->modelClass;
                    $this->data['Attachment']['description'] = 'City Image';
                    $this->data['Attachment']['id'] = $attach['Attachment']['id'];
                    $this->data['Attachment']['foreign_id'] = $this->City->id;
                    $data['Attachment']['filename'] = $this->data['Attachment']['filename'];
                    $this->City->Attachment->Behaviors->attach('ImageUpload', Configure::read('image.file'));
                    $this->City->Attachment->set($data);
                    if ($this->City->Attachment->validates()) {
                        $this->City->Attachment->save($this->data['Attachment']);
                    }
                    $this->Session->setFlash(__l(' City has been added') , 'default', array('lib' => __l('Success')), 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l(' City could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data['City']['is_approved'] = 1;
        }
        $countries = $this->City->Country->find('list', array(
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'order' => array(
                'State.name'
            )
        ));
        //get languages
        App::import('Model', 'Translation');
        $this->Translation = new Translation();
        $languages = $this->Translation->get_languages();
        //end
        $this->set(compact('countries', 'states', 'languages'));
    }
    // To change approve/disapprove status by admin
    function admin_update_status($id = null, $status = null)
    {
        if (is_null($id) || is_null($status)) {
            $this->cakeError('error404');
        }
        $this->data['City']['id'] = $id;
        if ($status == 'disapprove') {
            $this->data['City']['is_approved'] = 0;
        }
        if ($status == 'approve') {
            $this->data['City']['is_approved'] = 1;
        }
        $this->City->save($this->data);
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->data['City'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['redirect_url']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $cityIds = array();
            foreach($this->data['City'] as $city_id => $is_checked) {
                if ($is_checked['id']) {
                    $cityIds[] = $city_id;
                }
            }
            $defaultCity = $this->City->find('first', array(
                'conditions' => array(
                    'City.slug' => Configure::read('site.city')
                ) ,
                'fields' => array(
                    'City.id'
                ) ,
                'recursive' => -1
            ));
            if ($actionid && !empty($cityIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->City->updateAll(array(
                        'City.is_approved' => 0
                    ) , array(
                        'City.id' => $cityIds,
                        'City.slug !=' => Configure::read('site.city')
                    ));
                    $msg = __l('Selected cities has been disapproved');
                    if (!empty($defaultCity) && in_array($defaultCity['City']['id'], $cityIds)) {
                        if (count($cityIds) == 1) {
                            $this->Session->setFlash(__l('You cannot disapprove the default city. Please update default city from settings and try again.') , 'default', array('lib' => __l('Error')), 'error');
                            $msg = '';
                        } else {
                            $msg.= ' ' . __l('except the default city. Please update default city from settings and try again.');
                        }
                    }
                    if (!empty($msg)) $this->Session->setFlash($msg, 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->City->updateAll(array(
                        'City.is_approved' => 1
                    ) , array(
                        'City.id' => $cityIds
                    ));
                    $this->Session->setFlash(__l('Selected cities has been activated') , 'default', array('lib' => __l('Success')), 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    $this->City->deleteAll(array(
                        'City.id' => $cityIds,
                        'City.slug !=' => Configure::read('site.city')
                    ));
                    $msg = __l('Selected cities has been deleted');
                    if (!empty($defaultCity) && in_array($defaultCity['City']['id'], $cityIds)) {
                        if (count($cityIds) == 1) {
                            $this->Session->setFlash(__l('You can not delete the default city. Please update default city from settings and try again.') , 'default', array('lib' => __l('Error')), 'error');
                            $msg = '';
                        } else {
                            $msg.= ' ' . __l('except the default city. Please update default city from settings and try again.');
                        }
                    }
                    if (!empty($msg)) $this->Session->setFlash($msg, 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $defaultCity = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => Configure::read('site.city')
            ) ,
            'fields' => array(
                'City.id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($defaultCity) && $id == $defaultCity['City']['id']) {
            $this->Session->setFlash(__l('You can not delete the default city. Please update default city from settings and try again.') , 'default', array('lib' => __l('Error')), 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($this->City->del($id)) {
            $this->Session->setFlash(__l('City deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function fb_update()
    {
        if ($fb_session = $this->facebook->getSession()) {
            $city = $this->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->params['named']['city']
                ) ,
                'fields' => array(
                    'City.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($city)) {
                $this->data['City']['id'] = $city['City']['id'];
                $this->data['City']['fb_user_id'] = $fb_session['uid'];
                $this->data['City']['fb_access_token'] = $fb_session['access_token'];
                if ($this->City->save($this->data)) {
                    $this->Session->setFlash(__l('Facebook credentials updated for selected city') , 'default', array('lib' => __l('Success')), 'success');
                } else {
                    $this->Session->setFlash(__l('Facebook credentials could not be updated for selected city. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
            }
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    function check_city($city_name = null)
    {
        $this->autoRender = false;
        if (!empty($this->params['named']['city_name'])) {
            $get_city = $this->City->find('first', array(
                'conditions' => array(
                    'City.name' => $this->params['named']['city_name'],
                    'City.is_approved' => 1,
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_city)) {
                echo $get_city['City']['name'];
            }
        }
        exit;
    }
    function admin_change_city()
    {
        if (!empty($this->data)) {
            if (!empty($this->data['City']['city_id'])) {
                $this->Session->write('city_filter_id', $this->data['City']['city_id']);
            } else {
                $this->Session->del('city_filter_id');
            }
            $this->redirect(Router::url('/', true) . $this->data['City']['r']);
        }
    }
}
?>