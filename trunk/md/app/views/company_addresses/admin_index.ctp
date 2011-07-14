<?php /* SVN: $Id: admin_index.ctp 4685 2010-05-14 08:47:13Z mohanraj_109at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="companyAddresses index">
<h2><?php echo __l('Company Addresses');?></h2>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $paginator->sort('id');?></th>
        <th><?php echo $paginator->sort('created');?></th>
        <th><?php echo $paginator->sort('modified');?></th>
        <th><?php echo $paginator->sort('address1');?></th>
        <th><?php echo $paginator->sort('address2');?></th>
        <th><?php echo $paginator->sort('company_id');?></th>
        <th><?php echo $paginator->sort('city_id');?></th>
        <th><?php echo $paginator->sort('state_id');?></th>
        <th><?php echo $paginator->sort('country_id');?></th>
        <th><?php echo $paginator->sort('phone');?></th>
        <th><?php echo $paginator->sort('zip');?></th>
        <th><?php echo $paginator->sort('url');?></th>
        <th><?php echo $paginator->sort('latitude');?></th>
        <th><?php echo $paginator->sort('longitude');?></th>
    </tr>
<?php
if (!empty($companyAddresses)):

$i = 0;
foreach ($companyAddresses as $companyAddress):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $html->link(__l('Edit'), array('action' => 'edit', $companyAddress['CompanyAddress']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $companyAddress['CompanyAddress']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $html->cInt($companyAddress['CompanyAddress']['id']);?></td>
		<td><?php echo $html->cDateTime($companyAddress['CompanyAddress']['created']);?></td>
		<td><?php echo $html->cDateTime($companyAddress['CompanyAddress']['modified']);?></td>
		<td><?php echo $html->cText($companyAddress['CompanyAddress']['address1']);?></td>
		<td><?php echo $html->cText($companyAddress['CompanyAddress']['address2']);?></td>
		<td><?php echo $html->link($html->cText($companyAddress['Company']['name']), array('controller'=> 'companies', 'action'=>'view', $companyAddress['Company']['slug']), array('escape' => false));?></td>
		<td><?php echo $html->link($html->cText($companyAddress['City']['name']), array('controller'=> 'cities', 'action'=>'view', $companyAddress['City']['slug']), array('escape' => false));?></td>
		<td><?php echo $html->link($html->cText($companyAddress['State']['name']), array('controller'=> 'states', 'action'=>'view', $companyAddress['State']['id']), array('escape' => false));?></td>
		<td><?php echo $html->link($html->cText($companyAddress['Country']['name']), array('controller'=> 'countries', 'action'=>'view', $companyAddress['Country']['slug']), array('escape' => false));?></td>
		<td><?php echo $html->cText($companyAddress['CompanyAddress']['phone']);?></td>
		<td><?php echo $html->cInt($companyAddress['CompanyAddress']['zip']);?></td>
		<td><?php echo $html->cText($companyAddress['CompanyAddress']['url']);?></td>
		<td><?php echo $html->cFloat($companyAddress['CompanyAddress']['latitude']);?></td>
		<td><?php echo $html->cFloat($companyAddress['CompanyAddress']['longitude']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><?php echo __l('No Company Addresses available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($companyAddresses)) {
    echo $this->element('paging_links');
}
?>
</div>
