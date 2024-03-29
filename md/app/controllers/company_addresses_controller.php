<?php
class CompanyAddressesController extends AppController
{
    var $name = 'CompanyAddresses';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'City',
            'State',
            'CompanyAddress.latitude',
            'CompanyAddress.longitude',
        );
        parent::beforeFilter();
    }
    function index()
    {
        $company = $this->CompanyAddress->Company->find('first', array(
            'conditions' => array(
                'Company.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'Company.id',
                'Company.name',
                'Company.slug',
                'Company.is_company_profile_enabled'
            ) ,
            'recursive' => -1
        ));
        if (empty($company)) {
            $this->cakeError('error404');
        }
        $this->pageTitle = __l('Company Addresses');
        $this->CompanyAddress->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'CompanyAddress.company_id = ' => $company['Company']['id']
            )
        );
        $this->set('companyAddresses', $this->paginate());
        $this->set('company_id', $company['Company']['id']);
    }
    function view($id = null)
    {
        $this->pageTitle = __l('Company Address');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $companyAddress = $this->CompanyAddress->find('first', array(
            'conditions' => array(
                'CompanyAddress.id = ' => $id
            ) ,
            'fields' => array(
                'CompanyAddress.id',
                'CompanyAddress.created',
                'CompanyAddress.modified',
                'CompanyAddress.address1',
                'CompanyAddress.address2',
                'CompanyAddress.company_id',
                'CompanyAddress.city_id',
                'CompanyAddress.state_id',
                'CompanyAddress.country_id',
                'CompanyAddress.phone',
                'CompanyAddress.zip',
                'CompanyAddress.url',
                'CompanyAddress.latitude',
                'CompanyAddress.longitude',
                'Company.id',
                'Company.created',
                'Company.modified',
                'Company.name',
                'Company.slug',
                'Company.address1',
                'Company.address2',
                'Company.email',
                'Company.user_id',
                'Company.city_id',
                'Company.state_id',
                'Company.country_id',
                'Company.phone',
                'Company.zip',
                'Company.url',
                'Company.deal_count',
                'Company.is_online_account',
                'Company.is_company_profile_enabled',
                'Company.company_profile',
                'Company.latitude',
                'Company.longitude',
                'City.id',
                'City.created',
                'City.modified',
                'City.country_id',
                'City.state_id',
                'City.name',
                'City.slug',
                'City.latitude',
                'City.longitude',
                'City.dma_id',
                'City.county',
                'City.code',
                'City.deal_count',
                'City.is_approved',
                'City.twitter_username',
                'City.twitter_password',
                'City.twitter_url',
                'City.facebook_url',
                'State.id',
                'State.country_id',
                'State.name',
                'State.code',
                'State.adm1code',
                'State.is_approved',
                'Country.id',
                'Country.name',
                'Country.fips104',
                'Country.iso2',
                'Country.iso3',
                'Country.ison',
                'Country.internet',
                'Country.capital',
                'Country.map_reference',
                'Country.nationality_singular',
                'Country.nationality_plural',
                'Country.currency',
                'Country.currency_code',
                'Country.population',
                'Country.title',
                'Country.comment',
                'Country.slug',
            ) ,
            'recursive' => 0,
        ));
        if (empty($companyAddress)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $companyAddress['CompanyAddress']['id'];
        $this->set('companyAddress', $companyAddress);
    }
    function add()
    {
        $this->pageTitle = __l('Add Company Address');
        if (!empty($this->data)) {
            $this->CompanyAddress->set($this->data);
            $this->CompanyAddress->State->set($this->data);
            $this->CompanyAddress->City->set($this->data);
            if ($this->CompanyAddress->validates() &$this->CompanyAddress->City->validates() &$this->CompanyAddress->State->validates()) {
                $this->data['CompanyAddress']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->CompanyAddress->City->findOrSaveAndGetId($this->data['City']['name']);
                $this->data['CompanyAddress']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->CompanyAddress->State->findOrSaveAndGetId($this->data['State']['name']);
                $this->CompanyAddress->create();
                $this->CompanyAddress->save($this->data);
                $this->Session->setFlash(__l('Company Address has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'company_addresses',
                    'action' => 'index',
                    $this->data['CompanyAddress']['company_id']
                ));
            } else {
                $this->Session->setFlash(__l('Company Address could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
		unset($this->CompanyAddress->Company->City->validate['City']);
        if (!empty($this->params['named']['company_id'])) {
            $this->data['CompanyAddress']['company_id'] = $this->params['named']['company_id'];
        }
        $countries = $this->CompanyAddress->Country->find('list');
        $this->set(compact('countries'));
    }
    function edit($id = null)
    {
        $this->pageTitle = __l('Edit Company Address');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            $this->CompanyAddress->set($this->data);
            $this->CompanyAddress->State->set($this->data);
            $this->CompanyAddress->City->set($this->data);
            if ($this->CompanyAddress->validates() &$this->CompanyAddress->City->validates() &$this->CompanyAddress->State->validates()) {
                $this->data['CompanyAddress']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->CompanyAddress->City->findOrSaveAndGetId($this->data['City']['name']);
                $this->data['CompanyAddress']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->CompanyAddress->State->findOrSaveAndGetId($this->data['State']['name']);
                $this->CompanyAddress->save($this->data);
                $this->Session->setFlash(__l('Company Address has been updated') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'company_addresses',
                    'action' => 'index',
                    $this->data['CompanyAddress']['company_id']
                ));
            } else {
                $this->Session->setFlash(__l('Company Address could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->CompanyAddress->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
		unset($this->CompanyAddress->Company->City->validate['City']);
        $this->pageTitle.= ' - ' . $this->data['CompanyAddress']['id'];
        $countries = $this->CompanyAddress->Country->find('list');
        $this->set(compact('countries'));
    }
    function delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->CompanyAddress->del($id)) {
            if ($this->RequestHandler->isAjax()) {
                echo 'deleted';
                exit;
            }
            $this->Session->setFlash(__l('Company Address deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Company Addresses');
        $this->CompanyAddress->recursive = 0;
        $this->set('companyAddresses', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Company Address');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $companyAddress = $this->CompanyAddress->find('first', array(
            'conditions' => array(
                'CompanyAddress.id = ' => $id
            ) ,
            'fields' => array(
                'CompanyAddress.id',
                'CompanyAddress.created',
                'CompanyAddress.modified',
                'CompanyAddress.address1',
                'CompanyAddress.address2',
                'CompanyAddress.company_id',
                'CompanyAddress.city_id',
                'CompanyAddress.state_id',
                'CompanyAddress.country_id',
                'CompanyAddress.phone',
                'CompanyAddress.zip',
                'CompanyAddress.url',
                'CompanyAddress.latitude',
                'CompanyAddress.longitude',
                'Company.id',
                'Company.created',
                'Company.modified',
                'Company.name',
                'Company.slug',
                'Company.address1',
                'Company.address2',
                'Company.email',
                'Company.user_id',
                'Company.city_id',
                'Company.state_id',
                'Company.country_id',
                'Company.phone',
                'Company.zip',
                'Company.url',
                'Company.deal_count',
                'Company.is_online_account',
                'Company.is_company_profile_enabled',
                'Company.company_profile',
                'Company.latitude',
                'Company.longitude',
                'City.id',
                'City.created',
                'City.modified',
                'City.country_id',
                'City.state_id',
                'City.name',
                'City.slug',
                'City.latitude',
                'City.longitude',
                'City.dma_id',
                'City.county',
                'City.code',
                'City.deal_count',
                'City.is_approved',
                'City.twitter_username',
                'City.twitter_password',
                'City.twitter_url',
                'City.facebook_url',
                'State.id',
                'State.country_id',
                'State.name',
                'State.code',
                'State.adm1code',
                'State.is_approved',
                'Country.id',
                'Country.name',
                'Country.fips104',
                'Country.iso2',
                'Country.iso3',
                'Country.ison',
                'Country.internet',
                'Country.capital',
                'Country.map_reference',
                'Country.nationality_singular',
                'Country.nationality_plural',
                'Country.currency',
                'Country.currency_code',
                'Country.population',
                'Country.title',
                'Country.comment',
                'Country.slug',
            ) ,
            'recursive' => 0,
        ));
        if (empty($companyAddress)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $companyAddress['CompanyAddress']['id'];
        $this->set('companyAddress', $companyAddress);
    }
    function admin_add()
    {
        $this->pageTitle = __l('Add Company Address');
        if (!empty($this->data['CompanyAddress']['company_id'])) {
            $company = $this->CompanyAddress->Company->find('first', array(
                'conditions' => array(
                    'Company.id' => $this->data['CompanyAddress']['company_id']
                ) ,
                'recursive' => -1
            ));
        } else {
            $company = $this->CompanyAddress->Company->find('first', array(
                'conditions' => array(
                    'Company.slug' => $this->params['named']['company']
                ) ,
                'recursive' => -1
            ));
        }
        $this->pageTitle.= ' - ' . $company['Company']['name'];
        if (!empty($this->data)) {
            $this->CompanyAddress->set($this->data);
            $this->CompanyAddress->State->set($this->data);
            $this->CompanyAddress->City->set($this->data);
            if ($this->CompanyAddress->validates() &$this->CompanyAddress->City->validates() &$this->CompanyAddress->State->validates()) {
                $this->data['CompanyAddress']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->CompanyAddress->City->findOrSaveAndGetId($this->data['City']['name']);
                $this->data['CompanyAddress']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->CompanyAddress->State->findOrSaveAndGetId($this->data['State']['name']);
                $this->CompanyAddress->create();
                $this->CompanyAddress->save($this->data);
                $this->Session->setFlash(__l('Company Address has been added') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'companies',
                    'action' => 'edit',
                    $this->data['CompanyAddress']['company_id']
                ));
            } else {
                $this->Session->setFlash(__l('Company Address could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        if (!empty($this->params['named']['company'])) {
            $this->data['CompanyAddress']['company_id'] = $company['Company']['id'];
        }
        $countries = $this->CompanyAddress->Country->find('list');
        $this->set(compact('countries'));
    }
    function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Company Address');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            $this->CompanyAddress->set($this->data);
            $this->CompanyAddress->State->set($this->data);
            $this->CompanyAddress->City->set($this->data);
            if ($this->CompanyAddress->validates() &$this->CompanyAddress->City->validates() &$this->CompanyAddress->State->validates()) {
                $this->data['CompanyAddress']['city_id'] = !empty($this->data['City']['id']) ? $this->data['City']['id'] : $this->CompanyAddress->City->findOrSaveAndGetId($this->data['City']['name']);
                $this->data['CompanyAddress']['state_id'] = !empty($this->data['State']['id']) ? $this->data['State']['id'] : $this->CompanyAddress->State->findOrSaveAndGetId($this->data['State']['name']);
                $this->CompanyAddress->save($this->data);
                $this->Session->setFlash(__l('Company Address has been updated') , 'default', array('lib' => __l('Success')), 'success');
                $this->redirect(array(
                    'controller' => 'companies',
                    'action' => 'edit',
                    $this->data['CompanyAddress']['company_id']
                ));
            } else {
                $this->Session->setFlash(__l('Company Address could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->CompanyAddress->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Company']['name'];
        $countries = $this->CompanyAddress->Country->find('list');
        $this->set(compact('countries'));
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->CompanyAddress->del($id)) {
            if ($this->RequestHandler->isAjax()) {
                echo 'deleted';
                exit;
            }
            $this->Session->setFlash(__l('Company Address deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>