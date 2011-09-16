<?php
class EmailTemplatesController extends AppController
{
    var $name = 'EmailTemplates';
    function admin_index()
    {
        $this->pageTitle = __l('Email Templates');
        $this->EmailTemplate->recursive = -1;
        $this->paginate = array(
            'limit' => 50,
            'order' => array(
                'EmailTemplate.name' => 'ASC'
            )
        );
        $this->set('emailTemplates', $this->paginate());
    }
    function admin_edit($id = null)
    {
        $this->disableCache();
		$this->EmailTemplate->Behaviors->detach('i18n');
        $this->pageTitle = __l('Edit Email Template');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if (!empty($this->data)) {
            if (Configure::read('site.is_admin_settings_enabled')) {
                if ($this->EmailTemplate->save($this->data)) {
                    $this->Session->setFlash(__l('Email Template has been updated') , 'default', array('lib' => __l('Success')), 'success');
                } else {
                    $this->Session->setFlash(__l('Email Template could not be updated. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
                $emailTemplate = $this->EmailTemplate->find('first', array(
                    'conditions' => array(
                        'EmailTemplate.id' => $this->data['EmailTemplate']['id']
                    ) ,
                    'fields' => array(
                        'EmailTemplate.name',
                        'EmailTemplate.email_variables',
                        'EmailTemplate.description',
                        'EmailTemplate.is_html'
                    ) ,
                    'recursive' => -1
                ));
                $this->data['EmailTemplate']['name'] = $emailTemplate['EmailTemplate']['name'];
                $this->data['EmailTemplate']['email_variables'] = $emailTemplate['EmailTemplate']['email_variables'];
                $this->data['EmailTemplate']['description'] = $emailTemplate['EmailTemplate']['description'];
                $this->set('emailTemplate', $emailTemplate);
            } else {
                $this->Session->setFlash(__l('Sorry. You Cannot Update the Settings in Demo Mode') , 'default', array('lib' => __l('Error')), 'error');
            }
        } else {
            $this->data = $this->EmailTemplate->read(null, $id);
            if (empty($this->data)) {
                $this->cakeError('error404');
            }
        }
        $this->pageTitle.= ' - ' . $this->data['EmailTemplate']['name'];
        $this->set('email_variables', explode(',', $this->data['EmailTemplate']['email_variables']));
    }
}
?>