<?php /* SVN: $Id: admin_add.ctp 6608 2010-06-02 13:31:30Z sreedevi_140ac10 $ */ ?>
<div class="subscriptions form">
<?php echo $form->create('Subscription', array('class' => 'normal'));?>
	<div>
 		<h2><?php echo __l('Add Subscription');?></h2>
    </div>
    <div>
    	<?php
    		echo $form->input('user_id',array('label' => __l('User')));
    		echo $form->input('city_id',array('label' => __l('City')));
    		echo $form->input('email',array('label' => __l('Email')));
    	?>
	</div>
    <?php echo $form->end(__l('Add'));?>
</div>
