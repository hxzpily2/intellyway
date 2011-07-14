<?php /* SVN: $Id: admin_edit.ctp 6611 2010-06-02 13:32:39Z sreedevi_140ac10 $ */ ?>
<div class="subscriptions form">
<?php echo $form->create('Subscription', array('class' => 'normal'));?>
	<div>
 		<h2><?php echo __l('Edit Subscription');?></h2>
    </div>
    <div>
	<?php
		echo $form->input('id');
		echo $form->input('user_id',array('label' => __l('User')));
		echo $form->input('city_id',array('label' => __l('City')));
		echo $form->input('email',array('label' => __l('Email')));
	?>
	</div>
<?php echo $form->end(__l('Update'));?>
</div>
