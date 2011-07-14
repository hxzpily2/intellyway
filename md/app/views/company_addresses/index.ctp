<?php /* SVN: $Id: index.ctp 4730 2010-05-14 13:50:53Z mohanraj_109at09 $ */ ?>
<div class="companyAddresses index clearfix  js-responses js-response">
<h2><?php echo __l('Company Addresses');?></h2>
<div class="add-block">
<?php echo $html->link(__l('Add address'),'#',array('title'=>__l('Add address'),'class' => "js-toggle-show add {'container':'js-redeem-form'}")); ?>
</div>
            <div class="js-redeem-form hide" >
                <?php echo $this->element('company_addresses-add', array('company_id' => $company_id, 'cache' => array('time' => Configure::read('site.element_cache')), 'plugin' => 'site_tracker')); ?>
            </div>
<?php echo $this->element('paging_counter');?>
<ol class="list clearfix">
<?php
if (!empty($companyAddresses)):

$i = 0;
foreach ($companyAddresses as $companyAddress):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = "altrow";
	}
?>
	 <li class= "vcard clearfix <?php echo $class;?>" >
			<div class="address-actions">

					<?php echo $html->link(__l('Edit'), array('action' => 'edit', $companyAddress['CompanyAddress']['id']), array('class' => 'edit js-inline-edit', 'title' => __l('Edit')));?>

					<?php echo $html->link(__l('Delete'), array('action' => 'delete', $companyAddress['CompanyAddress']['id']), array('class' => 'delete js-on-the-fly-delete', 'title' => __l('Delete')));?>

			</div>
            <address>
				<?php echo $html->cText($companyAddress['CompanyAddress']['address1']);?>
				<?php
					if(!empty($companyAddress['CompanyAddress']['address2'])):
						 echo $html->cText($companyAddress['CompanyAddress']['address2']);
					endif;
				?>
				<?php echo $html->cText($companyAddress['City']['name']);?>
				<?php echo $html->cText($companyAddress['State']['name']);?>
				<?php echo $html->cText($companyAddress['Country']['name']);?>
				<?php echo $html->cText($companyAddress['CompanyAddress']['zip']);?>
            </address>
			<span class="phone"><?php echo  !empty($companyAddress['CompanyAddress']['phone'])? $html->cText($companyAddress['CompanyAddress']['phone']) : '&nbsp;';?></span>
			<span class="url"><?php echo  !empty($companyAddress['CompanyAddress']['url'])? $html->cText($companyAddress['CompanyAddress']['url']) : '&nbsp;';?></span>
	</li>
<?php
    endforeach;
else:
?>
	<li class="notice"><?php echo __l('No Company Addresses available');?></li>
<?php
endif;
?>
</ol>
<div class="js-pagination clearfix">
<?php
if (!empty($companyAddresses)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
