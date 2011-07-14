<?php /* SVN: $Id: add.ctp 6686 2010-06-03 05:54:02Z sreedevi_140ac10 $ */ ?>
<div class="businessSuggestions form">
<h2><?php echo __l('Suggest a Business');?></h2>
<?php echo $form->create('BusinessSuggestion', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $form->input('email',array('label' => __l('Email')));
		echo $form->input('suggestion',array('label' =>__l('Suggestion')));
	?>
	</fieldset>
    <div class="submit-block clearfix">
        <?php
        	echo $form->submit(__l('Suggest'));
        ?>
    </div>
        <?php
        	echo $form->end();
        ?>

</div>