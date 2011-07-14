<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges view">
<h2><?php echo __l('User Income Range');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($userIncomeRange['UserIncomeRange']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userIncomeRange['UserIncomeRange']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($userIncomeRange['UserIncomeRange']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Income');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($userIncomeRange['UserIncomeRange']['income']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Is Active');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cBool($userIncomeRange['UserIncomeRange']['is_active']);?></dd>
	</dl>
</div>

