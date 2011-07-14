<?php
class AuthorizenetDocaptureLogsController extends AppController
{
    var $name = 'AuthorizenetDocaptureLogs';
    function admin_index()
    {
        $this->pageTitle = __l('Authorizenet Docapture Logs');
        $this->AuthorizenetDocaptureLog->recursive = -1;
		$this->paginate['order'] = array(
			'id' => 'desc'
		);
        $this->set('authorizenetDocaptureLogs', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Authorizenet Docapture Log');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $authorizenetDocaptureLog = $this->AuthorizenetDocaptureLog->find('first', array(
            'conditions' => array(
                'AuthorizenetDocaptureLog.id = ' => $id
            ) ,
            'fields' => array(
                'AuthorizenetDocaptureLog.id',
                'AuthorizenetDocaptureLog.created',
                'AuthorizenetDocaptureLog.modified',
                'AuthorizenetDocaptureLog.deal_user_id',
                'AuthorizenetDocaptureLog.transactionid',
                'AuthorizenetDocaptureLog.authorize_amt',
                'AuthorizenetDocaptureLog.authorize_gateway_feeamt',
                'AuthorizenetDocaptureLog.authorize_taxamt',
                'AuthorizenetDocaptureLog.authorize_cvv2match',
                'AuthorizenetDocaptureLog.authorize_avscode',
                'AuthorizenetDocaptureLog.authorize_authorization_code',
                'AuthorizenetDocaptureLog.authorize_response_text',
                'AuthorizenetDocaptureLog.authorize_response',
            ) ,
            'recursive' => -1
        ));
        if (empty($authorizenetDocaptureLog)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $authorizenetDocaptureLog['AuthorizenetDocaptureLog']['id'];
        $this->set('authorizenetDocaptureLog', $authorizenetDocaptureLog);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->AuthorizenetDocaptureLog->del($id)) {
            $this->Session->setFlash(__l('Authorizenet Docapture Log deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>