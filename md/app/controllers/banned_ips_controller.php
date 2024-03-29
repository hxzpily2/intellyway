<?php
class BannedIpsController extends AppController
{
    var $name = 'BannedIps';
    function admin_index()
    {
        $this->pageTitle = __l('Banned IPs');
        $this->BannedIp->recursive = -1;
        $this->paginate = array(
            'order' => array(
                $this->modelClass . '.id' => 'desc'
            )
        );
        $this->set('bannedIps', $this->paginate());
        $moreActions = $this->BannedIp->moreActions;
        $this->set(compact('moreActions'));
    }
    function admin_add($banned_id = null)
    {
        $this->pageTitle = __l('Add Banned IP');
        if (!empty($this->data)) {
            if (!empty($this->data['BannedIp']['address'])) {
                $banned_id = $this->data['BannedIp']['address'];
            }
            $this->BannedIp->set($this->data);
            if ($this->data['BannedIp']['type_id'] == ConstBannedTypes::RefererBlock) {
                unset($this->BannedIp->validate['address']);
                $this->BannedIp->validate['address']['rule'] = 'url';
                $this->BannedIp->validate['address']['message'] = __l('Must be a valid URL');
                $this->BannedIp->validate['address']['allowEmpty'] = false;
            }
            if ($this->BannedIp->validates()) {
                // To get the local ip
                if (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $easyban_remote_ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $easyban_remote_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                // To set the time duration of banned ip
                if ($this->data['BannedIp']['duration_id'] == ConstBannedDurations::Days) {
                    $this->data['BannedIp']['timespan'] = ($this->data['BannedIp']['duration_time']*86400) +date('U');
                } else if ($this->data['BannedIp']['duration_id'] == ConstBannedDurations::Weeks) {
                    $this->data['BannedIp']['timespan'] = ($this->data['BannedIp']['duration_time']*604800) +date('U');
                } else {
                    $this->data['BannedIp']['timespan'] = 0;
                }
                $this->data['BannedIp']['thetime'] = date('U');
                $reserved[] = sprintf('%u', ip2long(gethostbyname('127.0.0.1')));
                $reserved[] = sprintf('%u', ip2long(gethostbyname('0.0.0.0')));
                $reserved[] = '::1';
                $reserved[] = sprintf('%u', ip2long(gethostbyname($easyban_remote_ip)));
                $reserved[] = strtolower(gethostbyaddr($easyban_remote_ip));
                $reserved[] = 'localhost';
                $data = $this->data;
                $is_own_site = 0;
                // to set the ip range
                if ($data['BannedIp']['type_id'] == ConstBannedTypes::IPRange) {
                    $data['BannedIp']['address'] = sprintf('%u', ip2long(gethostbyname($data['BannedIp']['address'])));
                    $data['BannedIp']['range'] = sprintf('%u', ip2long(gethostbyname($data['BannedIp']['range'])));
                } else if ($data['BannedIp']['type_id'] == ConstBannedTypes::SingleIPOrHostName) {
                    $data['BannedIp']['address'] = sprintf('%u', ip2long(gethostbyname($data['BannedIp']['address'])));
                    $data['BannedIp']['range'] = sprintf('%u', ip2long(gethostbyname($data['BannedIp']['address'])));
                } else if ($data['BannedIp']['type_id'] == ConstBannedTypes::RefererBlock) {
                    $data['BannedIp']['address'] = str_replace('http://', '', $data['BannedIp']['address']);
                    $banned_arr = explode('/', $data['BannedIp']['address']);
                    $data['BannedIp']['address'] = $banned_arr[0];
                    $referer_url = strtolower($data['BannedIp']['address']);
                    $site_url_arr = explode('/', str_replace('http://', '', Router::url('/', true)));
                    $site_url = $site_url_arr[0];
                    if ($site_url != $referer_url) {
                        $data['BannedIp']['referer_url'] = $referer_url;
                    } else {
                        $is_own_site = 1;
                    }
                    unset($data['BannedIp']['address']);
                    unset($data['BannedIp']['range']);
                }
                if (($data['BannedIp']['address'] && $data['BannedIp']['range']) || $data['BannedIp']['referer_url']) {
                    if ((!in_array(strtolower($data['BannedIp']['address']) , $reserved) and !in_array(strtolower($data['BannedIp']['range']) , $reserved)) and !($data['BannedIp']['address'] <= sprintf('%u', ip2long(gethostbyname($easyban_remote_ip))) and $data['BannedIp']['range'] >= sprintf('%u', ip2long(gethostbyname($easyban_remote_ip)))) and !($data['BannedIp']['range'] <= sprintf('%u', ip2long(gethostbyname($easyban_remote_ip))) and $data['BannedIp']['address'] >= sprintf('%u', ip2long(gethostbyname($easyban_remote_ip))))) {
                        $this->BannedIp->create();
                        if ($this->BannedIp->save($data)) {
                            $this->Session->setFlash(__l('Banned IP has been added') , 'default', array('lib' => __l('Success')), 'success');
                            $this->redirect(array(
                                'action' => 'index'
                            ));
                        } else {
                            $this->Session->setFlash(__l('Banned IP could not be added. Please, try again') , 'default', array('lib' => __l('Error')), 'error');
                        }
                    } else {
                        $this->Session->setFlash(__l('You cannot add your IP address. Please, try again') , 'default', array('lib' => __l('Error')), 'error');
                    }
                } else {
                    if (empty($is_own_site)) {
                        $this->Session->setFlash(__l('Banned IP could not be added. Please, try again') , 'default', array('lib' => __l('Error')), 'error');
                    } else {
                        $this->Session->setFlash(__l('You cannot add your own domain. Please, try again') , 'default', array('lib' => __l('Error')), 'error');
                    }
                }
            } else {
                $this->Session->setFlash(__l('Banned IP could not be added. Please, try again') , 'default', array('lib' => __l('Error')), 'error');
            }
        }
        if (!is_null($banned_id)) {
            $this->data['BannedIp']['address'] = $banned_id;
        }
        $this->set('ip', $this->RequestHandler->getClientIP());
        $this->set('types', $this->BannedIp->ipTypesOptions);
        $this->set('durations', $this->BannedIp->ipTimeOptions);
        if (empty($this->data['BannedIp']['type_id'])) {
            $this->data['BannedIp']['type_id'] = 1;
        }
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        if ($this->BannedIp->del($id)) {
            $this->Session->setFlash(__l('Banned IP deleted') , 'default', array('lib' => __l('Success')), 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->cakeError('error404');
        }
    }
    function admin_update()
    {
        if (!empty($this->data[$this->modelClass])) {
            $r = $this->data[$this->modelClass]['r'];
            $actionid = $this->data[$this->modelClass]['more_action_id'];
            unset($this->data[$this->modelClass]['r']);
            unset($this->data[$this->modelClass]['more_action_id']);
            $selectedIds = array();
            foreach($this->data[$this->modelClass] as $primary_key_id => $is_checked) {
                if ($is_checked['id']) {
                    $selectedIds[] = $primary_key_id;
                }
            }
            if ($actionid && !empty($selectedIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked banned IPs has been deleted') , 'default', array('lib' => __l('Success')), 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
}
?>