<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships view">
<h2><?php echo __l('User Relationship');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($userRelationship['UserRelationship']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userRelationship['UserRelationship']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userRelationship['UserRelationship']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Relationship');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($userRelationship['UserRelationship']['relationship']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Active');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cBool($userRelationship['UserRelationship']['is_active']);?></dd>
	</dl>
</div>

