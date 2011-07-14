<?php /* SVN: $Id: admin_add.ctp 6621 2010-06-02 13:42:00Z sreedevi_140ac10 $ */ ?>
<div class="languages form">
	<h2><?php echo __l('Add Language');?></h2>
	<?php echo $form->create('Language', array('class' => 'normal'));?>
	<?php
		echo $form->input('name',array('label' => __l('Name')));
		echo $form->input('iso2',array('label' => __l('Iso2')));
		echo $form->input('iso3',array('label' => __l('Iso3')));
		echo $form->input('is_active', array('label' => __l('Active')));
	?>
	<div class="submit-block clearfix">
		<?php echo $form->submit(__l('Add'));?>
		<div class="cancel-block">
			<?php echo $html->link(__l('Cancel'), array('controller' => 'languages', 'action' => 'index'), array('class' => 'cancel-link', 'title' => __l('Cancel'), 'escape' => false));?>
		</div>
	</div>
	<?php echo $form->end(); ?> 
</div>