<?php /* SVN: $Id: add.ctp 40719 2011-01-10 09:27:33Z josephine_065at09 $ */ ?>
<div class="citySuggestions form">
<h2><?php echo __l('City not listed? No problem!');?></h2>
<?php echo $form->create('CitySuggestion', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $form->input('email',array('label' => __l('Email')));
		echo $form->input('name',array('label' =>__l('City Name')));
	?>
	</fieldset>
    <div class="submit-block clearfix">
    <?php echo $form->submit(__l('Suggest a city'));?>
    </div>
    <?php echo $form->end();?>
</div>