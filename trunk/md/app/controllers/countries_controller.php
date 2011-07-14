<?php
class CountriesController extends AppController
{
    var $name = 'Countries';
    function admin_index()
    {
        if (!empty($this->data['Country']['q'])) {
            $this->params['named']['q'] = $this->data['Country']['q'];
        }
        $this->pageTitle = __l('Countries');
        $this->Country->recursive = -1;
        $this->paginate = array(
            'contain' => array(
                'City'
            ) ,
            'order' => array(
                'Country.name' => 'asc'
            ) ,
            'recursive' => 1
        );
        if (isset($this->params['named']['q'])) {
            $this->paginate['search'] = $this->params['named']['q'] = $this->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->params['named']['q']);
        }
        $this->set('countries', $this->paginate());
        $moreActions = $this->Country->moreActions;
        $this->set(compact('moreActions'));
        $this->set('pageTitle', $this->pageTitle);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Country');
        if (!empty($this->data)) {
            $this->Country->create();
            if ($this->Country->save($this->data)) {
                $this->Session->setFlash(__l('Country has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Country could not be updated. Please, try again') , 'default', null, 'error');
            }
        }
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Country');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if ($this->Country->save($this->data)) {
                $this->Session->setFlash(__l('Country has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Country could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->Country->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Country']['name'];
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Country->del($id)) {
            $this->Session->setFlash(__l('Country deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->data['Country'])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $countryIds = array();
            foreach($this->data['Country'] as $country_id => $is_checked) {
                if ($is_checked['id']) {
                    $countryIds[] = $country_id;
                }
            }
            if ($actionid && !empty($countryIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $city = $this->Country->City->find('first', array(
                        'conditions' => array(
                            'City.slug = ' => Configure::read('site.city')
                        ) ,
                        'fields' => array(
                            'City.country_id',
                        ) ,
                        'recursive' => -1,
                    ));
                    if (in_array($city['City']['country_id'], $countryIds)) {
                        $this->Session->setFlash(__l('Country could not be deleted. Please, check seleted country belongs to default city') , 'default', null, 'error');
                    } else {
                        $this->Country->deleteAll(array(
                            'Country.id' => $countryIds
                        ));
                        $this->Session->setFlash(__l('Checked countries has been deleted') , 'default', null, 'success');
                    }
                }
            }
        }
        $this->redirect(array(
            'controller' => 'countries',
            'action' => 'admin_index',
            'admin' => true
        ));
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
}
?>