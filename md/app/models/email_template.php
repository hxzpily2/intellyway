<?php
class EmailTemplate extends AppModel
{
    var $name = 'EmailTemplate';
    var $displayField = 'name';
	var $actsAs = array(
        'i18n' => array(
            'fields' => array(
               'subject','email_content'
            ),
            'display' => array('subject','email_content'),
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'from' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'email_content' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function selectTemplate($tempName, $lang_code = null)
    {
		$temp = Configure::read('lang_code');

		if(!is_null($lang_code))
			Configure::write('lang_code', $lang_code);
		
        $emailTemplate = $this->find('first', array(
            'conditions' => array(
                'EmailTemplate.name' => $tempName
            ) ,
            'recursive' => -1
        ));	
        $resultArray = array();
        foreach($emailTemplate as $singleArrayEmailTemplate) {
            foreach($singleArrayEmailTemplate as $key => $value) {
                $resultArray[$key] = $value;
            }
        }
		if(!is_null($lang_code))
			Configure::write('lang_code', $temp);
        return $resultArray;
    }
}
?>