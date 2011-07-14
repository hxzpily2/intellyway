<?php
	echo $form->create('Setting', array('class' => 'normal'));
	echo $form->input('name',array('label' => __l('Name')));
	echo $form->input('value',array('label' => __l('Value')));
	echo $form->input('description',array('label' => __l('Description')));
	echo $form->input('type', array('label' => __l('Type'),'type' => 'select', 'options' => array('text' => 'text', 'textarea' => 'textarea', 'checkbox' => 'checkbox', 'radio' => 'radio', 'password' => 'password')));
	echo $form->input('label',array('label' => __l('Label')));
	echo $form->end('Add');
	echo $html->link(__l('Cancel'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Cancel')));
?>