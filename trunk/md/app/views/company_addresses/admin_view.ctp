<?php /* SVN: $Id: admin_view.ctp 4685 2010-05-14 08:47:13Z mohanraj_109at09 $ */ ?>
<div class="companyAddresses view">
<h2><?php echo __l('Company Address');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($companyAddress['CompanyAddress']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($companyAddress['CompanyAddress']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cDateTime($companyAddress['CompanyAddress']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Address1');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($companyAddress['CompanyAddress']['address1']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Address2');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($companyAddress['CompanyAddress']['address2']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Company');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($companyAddress['Company']['name']), array('controller' => 'companies', 'action' => 'view', $companyAddress['Company']['slug']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('City');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($companyAddress['City']['name']), array('controller' => 'cities', 'action' => 'view', $companyAddress['City']['slug']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('State');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($companyAddress['State']['name']), array('controller' => 'states', 'action' => 'view', $companyAddress['State']['id']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Country');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->link($html->cText($companyAddress['Country']['name']), array('controller' => 'countries', 'action' => 'view', $companyAddress['Country']['slug']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Phone');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($companyAddress['CompanyAddress']['phone']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Zip');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cInt($companyAddress['CompanyAddress']['zip']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Url');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cText($companyAddress['CompanyAddress']['url']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Latitude');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cFloat($companyAddress['CompanyAddress']['latitude']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Longitude');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $html->cFloat($companyAddress['CompanyAddress']['longitude']);?></dd>
	</dl>
</div>

