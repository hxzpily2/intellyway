<?php
class TransactionsController extends AppController
{
    var $name = 'Transactions';
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Transaction.from_date',
            'Transaction.user_id',
            'Transaction.to_date'
        );
        parent::beforeFilter();
    }
    function index()
    {
		$this->disableCache();
        $this->pageTitle = __l('Transactions');
        $conditions['Transaction.user_id'] = $this->Auth->user('id');
        $blocked_conditions['UserCashWithdrawal.user_id'] = $this->Auth->user('id');
        $blocked_conditions['UserCashWithdrawal.withdrawal_status_id'] = array(
            ConstWithdrawalStatus::Pending,
            ConstWithdrawalStatus::Approved,
        );
        if (isset($this->data['Transaction']['from_date']) and isset($this->data['Transaction']['to_date'])) {
            $from_date = $this->data['Transaction']['from_date']['year'] . '-' . $this->data['Transaction']['from_date']['month'] . '-' . $this->data['Transaction']['from_date']['day'] . ' 00:00:00';
            $to_date = $this->data['Transaction']['to_date']['year'] . '-' . $this->data['Transaction']['to_date']['month'] . '-' . $this->data['Transaction']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->data)) {
            if ($from_date < $to_date) {
                $blocked_conditions['UserCashWithdrawal.created >='] = $conditions['Transaction.created >='] = _formatDate('Y-m-d H:i:s', $from_date, true);
                $blocked_conditions['UserCashWithdrawal.created <='] = $conditions['Transaction.created <='] = _formatDate('Y-m-d H:i:s', $to_date, true);
            } else {
                $this->Transaction->validationErrors['to_date'] = __l("'To date' should be greater than 'From date'.");
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 0;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 0;
            $this->pageTitle.= __l(' - Amount Earned today');
            $this->data['Transaction']['from_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
            $this->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 7;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 7;
            $this->pageTitle.= __l(' - Amount Earned in this week');
            $this->data['Transaction']['from_date'] = array(
                'year' => date('Y', strtotime('last week')) ,
                'month' => date('m', strtotime('last week')) ,
                'day' => date('d', strtotime('last week'))
            );
            $this->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('this week')) ,
                'month' => date('m', strtotime('this week')) ,
                'day' => date('d', strtotime('this week'))
            );
        }
        if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <= '] = 30;
            $blocked_conditions['TO_DAYS(NOW()) - TO_DAYS(UserCashWithdrawal.created) <= '] = 30;
            $this->pageTitle.= __l(' - Amount Earned in this month');
            $this->data['Transaction']['from_date'] = array(
                'year' => date('Y', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'month' => date('m', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'day' => date('d', (strtotime('this month', strtotime(date('m/01/y')))))
            );
            $this->data['Transaction']['to_date'] = array(
                'year' => date('Y', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'month' => date('m', (strtotime('this month', strtotime(date('m/01/y'))))) ,
                'day' => date('t', (strtotime('this month', strtotime(date('m/01/y')))))
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'TransactionType',
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.user_type_id',
						'User.fb_user_id',
                    )
                ) ,
                'GiftUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.user_type_id',
							'User.fb_user_id',
                        )
                    ) ,
                    'GiftedToUser' => array(
                        'fields' => array(
                            'GiftedToUser.id',
                            'GiftedToUser.username',
                            'GiftedToUser.user_type_id',
							'GiftedToUser.fb_user_id',
                        )
                    ) ,
                    'fields' => array(
                        'GiftUser.user_id',
                        'GiftUser.gifted_to_user_id',
                        'GiftUser.friend_mail'
                    )
                ) ,
                'DealUser' => array(
                    'Deal' => array(
                        'fields' => array(
                            'Deal.id',
                            'Deal.name',
                            'Deal.slug'
                        )
                    ) ,
                    'fields' => array(
                        'DealUser.id',
                        'DealUser.gift_email'
                    )
                ) ,
                'SecondUser',
                'Deal' => array(
                    'fields' => array(
                        'Deal.id',
                        'Deal.name',
                        'Deal.slug'
                    )
                )
            ) ,
            'order' => array(
                'Transaction.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $this->set('transactions', $this->paginate());
        $credit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                'TransactionType.is_credit' => 1
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
        $this->set('total_credit_amount', !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0);
        $debit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                'TransactionType.is_credit' => 0
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
        $this->set('total_debit_amount', !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0);
		if ((Configure::read('company.is_user_can_withdraw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::Company) || (Configure::read('user.is_user_can_with_draw_amount') && $this->Auth->user('user_type_id') == ConstUserTypes::User)){
			$blocked_amount = $this->Transaction->User->UserCashWithdrawal->find('first', array(
				'conditions' => $blocked_conditions,
				'fields' => array(
					'SUM(UserCashWithdrawal.amount) as total_amount'
				) ,
				'group' => array(
					'UserCashWithdrawal.user_id'
				) ,
				'recursive' => 0
			));
		}
        $this->set('blocked_amount', !empty($blocked_amount[0]['total_amount']) ? $blocked_amount[0]['total_amount'] : 0);
        if (empty($this->data)) {
            if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'week') {
                $this->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime("-7 days")) ,
                    'month' => date('m', strtotime("-7 days")) ,
                    'day' => date('d', strtotime("-7 days"))
                );
            } else if (isset($this->params['named']['stat']) && $this->params['named']['stat'] == 'month') {
                $this->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime('-30 days')) ,
                    'month' => date('m', strtotime('-30 days')) ,
                    'day' => date('d', strtotime('-30 days'))
                );
            } else {
                $this->data['Transaction']['from_date'] = array(
                    'year' => date('Y', strtotime('-90 days')) ,
                    'month' => date('m', strtotime('-90 days')) ,
                    'day' => date('d', strtotime('-90 days'))
                );
            }
            $this->data['Transaction']['to_date'] = array(
                'year' => date('Y', strtotime('today')) ,
                'month' => date('m', strtotime('today')) ,
                'day' => date('d', strtotime('today'))
            );
        }
    }
    function admin_index()
    {
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $conditions = array();
            if (!empty($this->params['named']['hash'])) {
                $hash = $this->params['named']['hash'];
            }
            if (!empty($hash) && isset($_SESSION['export_transactions'][$hash])) {
                $ids = implode(',', $_SESSION['export_transactions'][$hash]);
                if ($this->Transaction->isValidIdHash($ids, $hash)) {
                    $conditions['Transaction.id'] = $_SESSION['export_transactions'][$hash];
                } else {
                    $this->cakeError('error404');
                }
            }
            $this->set('TransactionObj', $this);
            $this->set('conditions', $conditions);
        } else {
            $this->pageTitle = __l('Transactions');
            if (!empty($this->params['named']['user_id'])) {
                $this->data['Transaction']['user_id'] = $this->params['named']['user_id'];
            }
            $conditions = array();
            if (empty($this->data['Transaction']['user_id']) && !empty($this->data['User']['username'])) {
                $user = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.username' => $this->data['User']['username']
                    ) ,
                    'fields' => array(
                        'User.id'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($user)) {
                    $this->data['Transaction']['user_id'] = $user['User']['id'];
                } else {
                    $this->data['Transaction']['user_id'] = null;
                }
            }
            if (!empty($this->data['Transaction']['user_id'])) {
                $this->params['named']['user_id'] = $this->data['Transaction']['user_id'];
                $users_info = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->data['Transaction']['user_id']
                    ) ,
                    'fields' => array(
                        'User.username'
                    ) ,
                    'recursive' => -1
                ));
                $this->data['Transaction']['user_id'] = $this->data['Transaction']['user_id'];
                $this->set('selected_user_info', !empty($users_info['User']['username']) ? ' - ' . $users_info['User']['username'] : '');
            }
            if (!empty($this->data['Transaction']['from_date']['year']) && !empty($this->data['Transaction']['from_date']['month']) && !empty($this->data['Transaction']['from_date']['day'])) {
                $this->params['named']['from_date'] = $this->data['Transaction']['from_date']['year'] . '-' . $this->data['Transaction']['from_date']['month'] . '-' . $this->data['Transaction']['from_date']['day'] . ' 00:00:00';
            }
            if (!empty($this->data['Transaction']['to_date']['year']) && !empty($this->data['Transaction']['to_date']['month']) && !empty($this->data['Transaction']['to_date']['day'])) {
                $this->params['named']['to_date'] = $this->data['Transaction']['to_date']['year'] . '-' . $this->data['Transaction']['to_date']['month'] . '-' . $this->data['Transaction']['to_date']['day'] . ' 23:59:59';
            }
            $param_string = '';
            $param_string.= !empty($this->params['named']['user_id']) ? '/user_id:' . $this->params['named']['user_id'] : $param_string;
            $param_string.= !empty($this->params['named']['from_date']) ? '/from_date:' . $this->params['named']['from_date'] : $param_string;
            $param_string.= !empty($this->params['named']['to_date']) ? '/to_date:' . $this->params['named']['to_date'] : $param_string;
            if (!empty($this->params['named']['user_id'])) {
                $conditions['Transaction.user_id'] = $this->params['named']['user_id'];
                $this->data['Transaction']['user_id'] = $this->params['named']['user_id'];
            }
            if (!empty($this->params['named']['type'])) {
                $conditions['Transaction.transaction_type_id'] = $this->params['named']['type'];
                $transaction_type = $this->Transaction->TransactionType->find('first', array(
                    'conditions' => array(
                        'TransactionType.id' => $this->params['named']['type']
                    ) ,
                    'fields' => array(
                        'TransactionType.name'
                    ) ,
                    'recursive' => -1
                ));
                $this->pageTitle.= ' - ' . $transaction_type['TransactionType']['name'];
            }
            if (!empty($this->params['named']['stat'])) {
                if (!empty($this->params['named']['stat'])) {
                    if ($this->params['named']['stat'] == 'day') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 0;
                        $this->pageTitle.= __l(' - Today');
                        $this->set('transaction_filter', __l('- Today'));
                        $days = 0;
                    } else if ($this->params['named']['stat'] == 'week') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 7;
                        $this->pageTitle.= __l(' - This Week');
                        $this->set('transaction_filter', __l('- This Week'));
                        $days = 7;
                    } else if ($this->params['named']['stat'] == 'month') {
                        $conditions['TO_DAYS(NOW()) - TO_DAYS(Transaction.created) <='] = 30;
                        $this->pageTitle.= __l(' - This Month');
                        $this->set('transaction_filter', __l('- This Month'));
                        $days = 30;
                    } else {
                        $this->pageTitle.= __l(' - Total');
                        $this->set('transaction_filter', __l('- Total'));
                    }
                }
            }
            if (empty($this->data)) {
                if (isset($days)) {
                    $this->data['Transaction']['from_date'] = array(
                        'year' => date('Y', strtotime("-$days days")) ,
                        'month' => date('m', strtotime("-$days days")) ,
                        'day' => date('d', strtotime("-$days days"))
                    );
                } else {
                    $this->data['Transaction']['from_date'] = array(
                        'year' => date('Y', strtotime('-90 days')) ,
                        'month' => date('m', strtotime('-90 days')) ,
                        'day' => date('d', strtotime('-90 days'))
                    );
                }
                $this->data['Transaction']['to_date'] = array(
                    'year' => date('Y', strtotime('today')) ,
                    'month' => date('m', strtotime('today')) ,
                    'day' => date('d', strtotime('today'))
                );
            }
            if (!empty($this->params['named']['from_date']) && !empty($this->params['named']['to_date'])) {
                if ($this->params['named']['from_date'] < $this->params['named']['to_date']) {
                    $conditions['Transaction.created >='] = _formatDate('Y-m-d H:i:s', $this->params['named']['from_date'], true);
                    $conditions['Transaction.created <='] = _formatDate('Y-m-d H:i:s', $this->params['named']['to_date'], true);
                } else {
                    $this->Session->setFlash(__l('From date should greater than To date. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
                }
            }
            $payment_options = $this->Transaction->getGatewayTypes('is_enable_for_add_to_wallet');
            if (empty($payment_options[ConstPaymentGateways::Wallet])) {
                $conditions['NOT']['Transaction.transaction_type_id'] = array(
                    ConstTransactionTypes::AddedToWallet,
                    ConstTransactionTypes::AddFundToWallet,
                    ConstTransactionTypes::DeductFundFromWallet,
                    ConstTransactionTypes::UserCashWithdrawalAmount,
                    ConstTransactionTypes::AcceptCashWithdrawRequest,
                    ConstTransactionTypes::UserWithdrawalRequest,
                    ConstTransactionTypes::AdminApprovedWithdrawalRequest,
                    ConstTransactionTypes::AdminRejecetedWithdrawalRequest,
                    ConstTransactionTypes::FailedWithdrawalRequest,
                    ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest,
                    ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest,
                    ConstTransactionTypes::FailedWithdrawalRequestRefundToUser
                );
            }
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'TransactionType',
                    'User' => array(
                        'UserAvatar',
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.user_type_id',
							'User.fb_user_id',
                        )
                    ) ,
                    'GiftUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.user_type_id',
								'User.fb_user_id',
                            )
                        ) ,
                        'GiftedToUser' => array(
                            'fields' => array(
                                'GiftedToUser.id',
                                'GiftedToUser.username',
                                'GiftedToUser.user_type_id',
								'GiftedToUser.fb_user_id',
                            )
                        ) ,
                        'fields' => array(
                            'GiftUser.user_id',
                            'GiftUser.gifted_to_user_id',
                            'GiftUser.friend_mail'
                        )
                    ) ,
                    'DealUser' => array(
                        'Deal' => array(
                            'fields' => array(
                                'Deal.id',
                                'Deal.name',
                                'Deal.slug'
                            )
                        ) ,
                        'fields' => array(
                            'DealUser.id',
                            'DealUser.gift_email'
                        )
                    ) ,
                    'Deal' => array(
                        'fields' => array(
                            'Deal.id',
                            'Deal.name',
                            'Deal.slug'
                        ) ,
                        'Company' => array(
                            'fields' => array(
                                'Company.name',
                                'Company.slug'
                            )
                        )
                    )
                ) ,
                'order' => array(
                    'Transaction.id' => 'desc'
                ) ,
                'recursive' => 2
            );
            $users = $this->Transaction->User->find('list', array(
                'conditions' => array(
                    'User.user_type_id !=' => ConstUserTypes::Admin,
                    'User.username !=' => ''
                ) ,
                'order' => array(
                    'User.username' => 'asc'
                )
            ));
            $export_transactions = $this->Transaction->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'Transaction.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($export_transactions)) {
                $ids = array();
                foreach($export_transactions as $export_transaction) {
                    $ids[] = $export_transaction['Transaction']['id'];
                }
                $hash = $this->Transaction->getIdHash(implode(',', $ids));
                $_SESSION['export_transactions'][$hash] = $ids;
                $this->set('export_hash', $hash);
            }
            $credit = $this->Transaction->find('first', array(
                'conditions' => array_merge($conditions, array(
                    'TransactionType.is_credit' => 1
                )) ,
                'fields' => array(
                    'SUM(Transaction.amount) as total_amount'
                ) ,
                'recursive' => 0
            ));
            $this->set('total_credit_amount', !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0);
            $debit = $this->Transaction->find('first', array(
                'conditions' => array_merge($conditions, array(
                    'TransactionType.is_credit' => 0
                )) ,
                'fields' => array(
                    'SUM(Transaction.amount) as total_amount'
                ) ,
                'recursive' => 0
            ));
            if (!empty($this->params['named']['user_id'])) {
                $user = $this->Transaction->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->params['named']['user_id']
                    ) ,
                    'recursive' => -1
                ));
                $this->set('user', $user);
            }
            $this->set('total_debit_amount', !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0);
            $this->set('users', $users);
            $this->set('transactions', $this->paginate());
            $this->set('param_string', $param_string);
            $this->set('pageTitle', $this->pageTitle);
            $this->Transaction->User->validate = array();
        }
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->Transaction->del($id)) {
            $this->Session->setFlash(__l('Transaction deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
}
?>