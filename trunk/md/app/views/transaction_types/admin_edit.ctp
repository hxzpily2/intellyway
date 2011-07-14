<?php /* SVN: $Id: $ */ ?>
<div class="transactionTypes form">
<h2><?php echo __l('Edit Transaction Type');?></h2>
<?php echo $form->create('TransactionType', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $form->input('id');?>		
	<?php if(!empty($this->data['TransactionType']['transaction_variables'])):
		echo $form->input('name', array('label'=>__l('Name')));
		echo $form->input('message', array('label'=>__l('Message'), 'info' => __l('Available Variables: ').$html->cText($this->data['TransactionType']['transaction_variables'])));
	else:
		echo $form->input('name', array('label'=>__l('Name')));
    endif;
	?>
	</fieldset>

   <div class="submit-block clearfix">
            <?php
            	echo $form->submit(__l('Update'));
            ?>
            </div>
        <?php
        	echo $form->end(); ?>
</div>
