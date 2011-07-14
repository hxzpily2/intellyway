<?php /* SVN: $Id: $ */ ?>
<div class="dealCategoriesSubscriptions view">
<h2><?php echo __l('Deal Categories Subscription');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Deal Category Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['deal_category_id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Subscription Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($dealCategoriesSubscription['DealCategoriesSubscription']['subscription_id']);?></dd>
	</dl>
</div>

