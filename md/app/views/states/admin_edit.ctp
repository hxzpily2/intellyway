<?php /* SVN: $Id: admin_edit.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="states form">
    <div>
        <div>
            <h2><?php echo __l('Edit State - ').$html->cText($this->data['State']['name']); ?></h2>
        </div>
        <div>
            <?php echo $form->create('State',  array('class' => 'normal','action'=>'edit'));?>
            <?php
                echo $form->input('id');
                echo $form->input('country_id',array('label' => __l('Country'),'empty'=>__l('Please Select')));
                echo $form->input('name',array('label' => __l('Name')));
                echo $form->input('code',array('label' => __l('Code')));
                echo $form->input('adm1code',array('label' => __l('Admlcode')));
                echo $form->input('is_approved', array('label' => __l('Approved?')));
            ?>
       
            <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Update'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
        </div>
    </div>
</div>

