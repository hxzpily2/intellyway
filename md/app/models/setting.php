<?php
/**
 * Setting Model
 *
 * Site settings.
 *
 */
class Setting extends AppModel
{
    var $validate = array();
    var $belongsTo = array(
        'SettingCategory' => array(
            'className' => 'SettingCategory',
            'foreignKey' => 'setting_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    var $hasOne = array(
        'SiteLogo' => array(
            'className' => 'SiteLogo',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'SiteLogo.class' => 'SiteLogo',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    /**
     * Find all settings of given type and transform them to key => value array
     *
     * @param string $type
     * @return array
     *
     * @TODO cache settings
     */
    function getKeyValuePairs()
    {
        $settings = $this->find('all');
        $names = Set::extract($settings, '{n}.Setting.name');
        $values = Set::extract($settings, '{n}.Setting.value');
        $settings = array_combine($names, $values);
        return $settings;
    }
}
