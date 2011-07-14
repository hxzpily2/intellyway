<?php
class PaypalTransactionLogsController extends AppController
{
    var $name = 'PaypalTransactionLogs';
    function admin_index()
    {
        $this->pageTitle = __l('Paypal Transaction Logs');
        $conditions = array();
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'mass') {
            $this->pageTitle = __l('Mass Paypal Transaction Logs');
            $conditions['PaypalTransactionLog.is_mass_pay'] = 1;
        } elseif (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'normal') {
            $this->pageTitle = __l('Normal Paypal Transaction Logs');
            $conditions['PaypalTransactionLog.is_mass_pay'] = 0;
        }
        $this->PaypalTransactionLog->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PaypalTransactionLog.id' => 'DESC'
            )
        );
        $this->set('paypalTransactionLogs', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Paypal Transaction Log');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $paypalTransactionLog = $this->PaypalTransactionLog->find('first', array(
            'conditions' => array(
                'PaypalTransactionLog.id = ' => $id
            ) ,
            'fields' => array(
                'PaypalTransactionLog.id',
                'PaypalTransactionLog.date_added',
                'PaypalTransactionLog.user_id',
                'PaypalTransactionLog.ip',
                'PaypalTransactionLog.currency_type',
                'PaypalTransactionLog.txn_id',
                'PaypalTransactionLog.payer_email',
                'PaypalTransactionLog.payment_date',
                'PaypalTransactionLog.email',
                'PaypalTransactionLog.to_digicurrency',
                'PaypalTransactionLog.to_account_no',
                'PaypalTransactionLog.to_account_name',
                'PaypalTransactionLog.fees_paid_by',
                'PaypalTransactionLog.mc_gross',
                'PaypalTransactionLog.mc_fee',
                'PaypalTransactionLog.mc_currency',
                'PaypalTransactionLog.payment_status',
                'PaypalTransactionLog.pending_reason',
                'PaypalTransactionLog.receiver_email',
                'PaypalTransactionLog.paypal_response',
                'PaypalTransactionLog.error_no',
                'PaypalTransactionLog.error_message',
                'PaypalTransactionLog.memo',
                'PaypalTransactionLog.paypal_post_vars',
                'User.id',
                'User.created',
                'User.modified',
                'User.user_type_id',
                'User.username',
                'User.email',
                'User.password',
                'User.is_active',
                'User.is_email_confirmed',
                'User.last_login_ip',
            ) ,
            'recursive' => 0,
        ));
        if (empty($paypalTransactionLog)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $paypalTransactionLog['PaypalTransactionLog']['id'];
        $this->set('paypalTransactionLog', $paypalTransactionLog);
    }
}
?>