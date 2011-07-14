
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<h2><?php echo __l('Update Email Templates');?></h2>

	<?php
		if (!empty($emailTemplates)):
	?>
	<div class="js-accordion">
		<?php
				foreach ($emailTemplates as $emailTemplate):
		?>		
				<h3>
					<?php echo $html->link($html->cText($emailTemplate['EmailTemplate']['name'], false).' - '. '<span>'.$html->truncate($emailTemplate['EmailTemplate']['description']).'</span>', array('controller' => 'email_templates', 'action' => 'edit', $emailTemplate['EmailTemplate']['id']), array('escape' => false));?>
				</h3>
				<div></div>
		<?php
				endforeach;
		?>
	</div>
	<?php
		else:
	?>
		<p class= "notice"><?php echo __l('No e-mail templates added yet.'); ?></p>
	<?php
		endif;
	?>	
