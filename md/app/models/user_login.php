<?php
class UserLogin extends AppModel
{
    var $name = 'UserLogin';
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function insertUserLogin($user_id)
    {
        $this->data['UserLogin']['user_id'] = $user_id;
        $this->data['UserLogin']['user_login_ip'] = RequestHandlerComponent::getClientIP();
        $this->data['UserLogin']['dns'] = gethostbyaddr(RequestHandlerComponent::getClientIP());
        $this->data['UserLogin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->save($this->data);
        $this->updateUserLanguage();
        if (empty($_SESSION['Auth']['User']['cim_profile_id'])) {
            $this->User->_createCimProfile($_SESSION['Auth']['User']['id']);
        }
    }
    function updateUserLanguage()
    {
        $language = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $_SESSION['Auth']['User']['id'],
            ) ,
            'fields' => array(
                'Language.iso2'
            ) ,
            'recursive' => 0
        ));
        if (!empty($language['Language']['iso2'])) {
            App::import('Component', 'Cookie');
            $objCookie = new CookieComponent();
            $objCookie->write('user_language', $language['Language']['iso2'], false);
        }
    }
    function afterSave($is_created)
    {
        $this->User->updateAll(array(
            'User.last_login_ip' => '\'' . RequestHandlerComponent::getClientIP() . '\'',
            'User.last_logged_in_time' => '\'' . date('Y-m-d H:i:s') . '\'',
            'User.dns' => '\'' . gethostbyaddr(RequestHandlerComponent::getClientIP()) . '\'',
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
    }
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>