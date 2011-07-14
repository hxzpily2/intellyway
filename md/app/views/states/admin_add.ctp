<?php /* SVN: $Id: admin_add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="states form">
    <div>
        <div>
            <h2><?php echo __l('Add State'); ?> </h2>
        </div>
        <div>
            <?php echo $form->create('State',  array('class' => 'normal','action'=>'add'));?>
            <?php
                echo $form->input('country_id',array('label' => __l('Country'),'empty'=>__l('Please Select')));
                echo $form->input('name',array('label' => __l('Name')));
                echo $form->input('code',array('label' => __l('Code')));
                echo $form->input('adm1code',array('label' => __l('Admlcode')));
                echo $form->input('is_approved', array('label' => __l('Approved?')));
            ?>
            <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Add'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
        </div>
    </div>
</div>
