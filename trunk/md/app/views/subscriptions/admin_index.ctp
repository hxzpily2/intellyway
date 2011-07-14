<?php /* SVN: $Id: admin_index.ctp 43046 2011-02-01 12:02:08Z usha_111at09 $ */ ?>
<?php if(empty($this->params['isAjax'])): ?>
<h2><?php echo $pageTitle;?></h2>
	<div class="js-tabs">
        <ul class="clearfix">
            <li><?php echo $html->link(sprintf(__l('Subscribed (%s)'),$subscribed), array('controller' => 'subscriptions', 'action' => 'index', 'type' => 'subscribed'),array('title' => __l('Subscribed'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Unsubscribed (%s)'),$unsubscribed), array('controller' => 'subscriptions', 'action' => 'index', 'type' => 'unsubscribed'),array('title' => __l('Unsubscribed'))); ?></li>
            <li><?php $total = $subscribed + $unsubscribed; echo $html->link(sprintf(__l('All (%s)'),$total), array('controller' => 'subscriptions', 'action' => 'index'),array('title' => __l('All'))); ?></li>
        </ul>
    </div>
<?php else: ?>
	<div class="subscriptions index js-response js-responses">
	<?php echo $form->create('Subscription', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form', 'action'=>'index')); ?>
        
                <?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
                <?php echo $form->input('type', array('type' => 'hidden')); ?>
                <?php echo $form->submit(__l('Search'));?>
          <?php echo $form->end(); ?>
		  <div class="add-block">
		  <?php //echo $html->link(__l('Update Subscribers'), array('controller' => 'subscriptions', 'action' => 'admin_update_subscribers'), array('info' => 'Update unsubscribers list to our database from mailchimp', 'title' => 'Update Subscribers', 'escape' => false)); ?>
		  <?php if(!empty($subscriptions)) {?>
		  <?php echo $html->link(__l('CSV'), array_merge(array('controller' => 'subscriptions', 'action' => 'index','city' => $city_slug, 'ext' => 'csv',  'admin' => true), $this->params['named']), array('class' => 'export', 'title' => 'CSV Export', 'escape' => false)); ?>
		  <?php } ?>
		  </div>
  <?php
     echo $form->create('Subscription' , array('class' => 'normal','action' => 'update'));
?>
  <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
  <?php echo $this->element('paging_counter'); ?>
  <table class="list">
    <tr>
      <th><?php echo __l('Select'); ?></th>
      <th><div class="js-pagination"><?php echo $paginator->sort(__l('Subscribed On'),'Subscription.created'); ?></div></th>
      <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Email'),'Subscription.email'); ?></div></th>
      <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('City'),'City.name'); ?></div></th>
      <?php if(empty($this->params['named']['type'])) { ?>
        <th><div class="js-pagination"><?php echo $paginator->sort(__l('Subscribed'),'Subscription.is_subscribed'); ?></div></th>
      <?php } ?>
    </tr>
    <?php
if (!empty($subscriptions)):
$i = 0;
foreach ($subscriptions as $subscription):
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
    if($subscription['Subscription']['is_subscribed']):
        $status_class = 'js-checkbox-active';
    else:
        $status_class = 'js-checkbox-inactive';
    endif;
	$online_class = 'offline';
	if (!empty($user['CkSession']['user_id'])) {
		$online_class = 'online';
	}
?>
    <tr<?php echo $class;?>>
      <td>
		<div class="actions-block">
			<div class="actions round-5-left">
	  			<span><?php echo $html->link(__l('Delete'), array('action'=>'delete', $subscription['Subscription']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
			</div>
		</div>
	  <?php echo $form->input('Subscription.'.$subscription['Subscription']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$subscription['Subscription']['id'], 'label' => false, 'class' =>$status_class.' js-checkbox-list', $online_class.' js-checkbox-list')); ?></td>
      <td><?php echo $html->cDateTime($subscription['Subscription']['created']);?></td>
      <td class="dl"><?php echo $html->cText($subscription['Subscription']['email']);?></td>
      <td class="dl"><?php echo $html->cText($subscription['City']['name']);?></td>
      <?php if(empty($this->params['named']['type'])) { ?>
        <td><?php echo $html->cBool($subscription['Subscription']['is_subscribed']);?></td>
      <?php } ?>
    </tr>
    <?php
    endforeach;
else:
?>
    <tr>
      <td colspan="14" class="notice"><?php echo __l('No Subscriptions available');?></td>
    </tr>
    <?php
endif;
?>
  </table>
  <?php
if (!empty($subscriptions)):
?>
  <div class="js-pagination"> <?php echo $this->element('paging_links'); ?> </div>
   <div class="admin-select-block">
	<div>
		<?php echo __l('Select:'); ?>
		<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
		<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
		<?php if(!isset($this->params['named']['type'])) { ?>
                <?php echo $html->link(__l('Subscribed'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Subscribed'))); ?>
                <?php echo $html->link(__l('Unsubscribed'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Unsubscribed'))); ?>
        <?php } ?>
	</div>
	<div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
		</div>
  <?php
endif;
echo $form->end();
?>
</div>
<?php endif; ?>