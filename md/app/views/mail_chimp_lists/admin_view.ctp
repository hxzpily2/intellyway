<?php /* SVN: $Id: $ */ ?>
<div class="mailChimpLists view">
<h2><?php echo __l('Mail Chimp List');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($mailChimpList['MailChimpList']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($mailChimpList['MailChimpList']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($mailChimpList['MailChimpList']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('City');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($mailChimpList['City']['name']), array('controller' => 'cities', 'action' => 'view', $mailChimpList['City']['slug']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('List Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($mailChimpList['MailChimpList']['list_id']);?></dd>
	</dl>
</div>

