<?php /* SVN: $Id: $ */ ?>
<div class="authorizeDocaptureLogs view">
<h2><?php echo __l('Authorizenet Docapture Log');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Transaction Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['transactionid']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Authorize Amt');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cFloat($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_amt']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Authorize Avscode');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_avscode']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Authorize Authorization Code');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_authorization_code']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Authorize Response Text');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_response_text']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Authorize Response');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($authorizenetDocaptureLog['AuthorizenetDocaptureLog']['authorize_response']);?></dd>
	</dl>
</div>