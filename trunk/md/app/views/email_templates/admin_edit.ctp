<div class="js-responses">
	<h2><?php echo $html->cText($this->data['EmailTemplate']['name'], false); ?></h2>
	<div class="info-details">
		<?php echo $html->cText($this->data['EmailTemplate']['description'], false); ?>
	</div>
<?php
	echo $form->create('EmailTemplate', array('id' => 'EmailTemplateAdminEditForm'.$this->data['EmailTemplate']['id'], 'class' => 'normal js-insert js-ajax-form', 'action' => 'edit'));
	echo $form->input('id');
	$link = $html->link(__l('Click here'), array('controller' => 'settings', 'action' => 'index','admin' => true), array('escape' => false, 'title' => __l('From Email')));
	echo $form->input('from', array('label' => __l('From'),'id' => 'EmailTemplateFrom'.$this->data['EmailTemplate']['id'], 'info' => sprintf(__l('%s to set common from email for all email templates'), $link)));
	echo $form->input('reply_to', array('label' => __l('Reply To'),'id' => 'EmailTemplateReplyTo'.$this->data['EmailTemplate']['id'], 'info' => sprintf(__l('%s to set common reply to email for all email templates'), $link)));
	echo $form->input('subject', array('label' => __l('Subject'),'class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->data['EmailTemplate']['id'],  'info' => $html->cText($this->data['EmailTemplate']['email_variables'], false)));
	echo $form->input('subject_ja', array('label' => __l('Subject (Japanese)'),'class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->data['EmailTemplate']['id'],  'info' => $html->cText($this->data['EmailTemplate']['email_variables'], false)));
        ?>
<span class="email-template"><?php echo __l('Email Type');?></span>
<?php
    echo $form->input('is_html', array('label' => __l('Is Html'),'type' => 'radio', 'legend' =>false, 'class' => 'js-toggle-editor', 'options' => array('0' => 'text', '1' => 'html')));
	echo $form->input('email_content', array('label' => __l('Email Content'),'type' =>'textarea', 'class' => 'js-email-content email-content js-editor', 'id' => 'EmailTemplateEmailContent'.$this->data['EmailTemplate']['id'], 'info' => $html->cText($this->data['EmailTemplate']['email_variables'], false)));
	echo $form->input('email_content_ja', array('label' => __l('Email Content (Japanese)'),'type' =>'textarea', 'class' => 'js-email-content email-content js-editor', 'id' => 'EmailTemplateEmailContent'.$this->data['EmailTemplate']['id'], 'info' => $html->cText($this->data['EmailTemplate']['email_variables'], false)));
    ?>
    <div class="submit-block clearfix">
    <?php
	echo $form->submit(__l('Update'));
?>
</div>
<?php
	echo $form->end();
?>
</div>