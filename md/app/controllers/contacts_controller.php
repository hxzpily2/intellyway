<?php
class ContactsController extends AppController
{
    var $name = 'Contacts';
    var $components = array(
        'Email',
        'RequestHandler'
    );
    var $uses = array(
        'Contact',
        'EmailTemplate',
        'UserProfile'
    );
    function add()
    {
        if (!empty($this->data)) {
            $this->Contact->set($this->data);
            if ($this->Contact->validates()) {
                $ip = $this->RequestHandler->getClientIP();
                $this->data['Contact']['ip'] = $ip;
                $this->data['Contact']['user_id'] = $this->Auth->user('id');
				$language_code = $this->Contact->getUserLanguageIso($this->Auth->user('id'));
				$email = $this->EmailTemplate->selectTemplate('Contact Us', $language_code);
                $emailFindReplace = array(
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##FIRST_NAME##' => $this->data['Contact']['first_name'],
                    '##LAST_NAME##' => !empty($this->data['Contact']['last_name']) ? ' ' . $this->data['Contact']['last_name'] : '',
                    '##FROM_EMAIL##' => $this->Contact->changeFromEmail((strstr($email['from'], '##FROM_EMAIL##')) ? str_replace('##FROM_EMAIL##', Configure::read('EmailTemplate.from_email') , $email['from']) : $email['from']) ,
                    '##FROM_URL##' => Router::url('/', true) . 'contactus',
                    '##SITE_ADDR##' => gethostbyaddr($ip) ,
                    '##IP##' => $ip,
                    '##TELEPHONE##' => $this->data['Contact']['telephone'],
                    '##MESSAGE##' => $this->data['Contact']['message'],
                    '##SUBJECT##' => $this->data['Contact']['subject'],
                    '##POST_DATE##' => date('F j, Y g:i:s A (l) T (\G\M\TP)', strtotime(date('Y-m-d H:i:s'))) ,
                    '##CONTACT_URL##' => Router::url(array(
                        'controller' => 'contacts',
                        'action' => 'add',
                        'city' => $this->params['named']['city'],
                        'admin' => false
                    ) , true) ,
                    '##SITE_URL##' => Router::url('/', true) ,
                    '##SITE_LINK##' => Router::url('/', true) ,
                    '##SITE_LOGO##' => Router::url(array(
                        'controller' => 'img',
                        'action' => 'blue-theme',
                        'logo-email.png',
                        'admin' => false
                    ) , true) ,
                    '##CONTACT_FROM_EMAIL##' => $this->data['Contact']['email']
                );
                // send to contact email
                $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                $this->Email->from = strtr($this->Email->from, $emailFindReplace);
                $this->Email->replyTo = strtr($this->Email->replyTo, $emailFindReplace);
                $this->Email->to = Configure::read('site.contact_email');
                $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                // reply email
				$language_code = $this->Contact->getUserLanguageIso($this->Auth->user('id'));
				$email = $this->EmailTemplate->selectTemplate('Contact Us Auto Reply', $language_code);
                $emailFindReplace['##FROM_EMAIL##'] = Configure::read('site.contact_email');
                $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                $this->Email->to = $this->data['Contact']['first_name'] . ' <' . $this->data['Contact']['email'] . '>';
                $this->Email->from = strtr($this->Email->from, $emailFindReplace);
                $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                $this->set('success', 1);
            } else {
                $this->Session->setFlash(__l('Contact could not be added. Please, try again.') , 'default', array('lib' => __l('Error')), 'error');
            }
            unset($this->data['Contact']['captcha']);
        } else {
            $SignedInUserDetail = $this->UserProfile->find('first', array(
                'conditions' => array(
                    'UserProfile.user_id' => $this->Auth->user('id')
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.email'
                        )
                    )
                ) ,
                'fields' => array(
                    'UserProfile.first_name',
                    'UserProfile.last_name',
                ) ,
                'recursive' => 0
            ));
            $this->data['Contact']['first_name'] = !empty($SignedInUserDetail['UserProfile']['first_name']) ? $SignedInUserDetail['UserProfile']['first_name'] : '';
            $this->data['Contact']['last_name'] = !empty($SignedInUserDetail['UserProfile']['last_name']) ? $SignedInUserDetail['UserProfile']['last_name'] : '';
            $this->data['Contact']['email'] = !empty($SignedInUserDetail['User']['email']) ? $SignedInUserDetail['User']['email'] : '';
        }
        $this->pageTitle = __l('Contact Us');
    }
}
?>