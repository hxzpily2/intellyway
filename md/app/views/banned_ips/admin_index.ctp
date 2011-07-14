<?php /* SVN: $Id: admin_index.ctp 13910 2010-07-16 14:34:46Z siva_063at09 $ */ ?>
<div class="bannedIps index js-response">
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
    <h2><?php echo __l('Banned IPs');?></h2>
    <div class="clearfix add-block">
        <?php echo $html->link(__l('Add'), array('controller' => 'banned_ips', 'action' => 'add'), array('class' => 'add','title' => __l('Add'))); ?>
    </div>
	<?php echo $this->element('paging_counter');?>
    <?php echo $form->create('BannedIp' , array('class' => 'normal', 'action' => 'update')); ?>
		<?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
		<table class="list">
			<tr>
            	<th><?php echo __l('Select'); ?></th>				
				<th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Victims'), 'BannedIp.address');?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Reason'), 'BannedIp.reason');?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Redirect to'), 'BannedIp.redirect');?></div></th>
				<th><div class="js-pagination"><?php echo $paginator->sort(__l('Date Set'), 'BannedIp.thetime');?></div></th>
				<th><div class="js-pagination"><?php echo $paginator->sort(__l('Expiry Date'), 'BannedIp.timespan');?></div></th>
			</tr>
			<?php
			if (!empty($bannedIps)):
				$i = 0;
				foreach ($bannedIps as $bannedIp):
					$class = null;
					if ($i++ % 2 == 0) :
						$class = ' class="altrow"';
					endif;
					?>
                    
					<tr<?php echo $class;?>>
					<td>
						<div class="actions-block">
							<div class="actions round-5-left">
								<?php echo $html->link(__l('Delete'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
							</div>
						</div>		 
						<?php echo $form->input('BannedIp.'.$bannedIp['BannedIp']['id'].'.id', array('type' 

=> 'checkbox', 'id' => "admin_checkbox_".$bannedIp['BannedIp']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
						</td>						
						<td class="dl">
							<?php
								if ($bannedIp['BannedIp']['referer_url']) :
									echo $bannedIp['BannedIp']['referer_url'];
								else:
									echo long2ip($bannedIp['BannedIp']['address']);
									if ($bannedIp['BannedIp']['range']) :
										echo ' - '.long2ip($bannedIp['BannedIp']['range']);
									endif;
								endif;
							?>
						</td>
						<td class="dl"><?php echo $html->cText($bannedIp['BannedIp']['reason']);?></td>
						<td class="dl"><?php echo $html->cText($bannedIp['BannedIp']['redirect']);?></td>
						<td><?php echo date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']); ?></td>
						<td><?php echo ($bannedIp['BannedIp']['timespan'] > 0) ? date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']) : __l('Never');?></td>
					</tr>
			<?php
				endforeach;
			else:
			?>
				<tr>
					<td colspan="7" class="notice"><?php echo __l('No Banned IPs available');?></td>
				</tr>
			<?php
			endif;
			?>
		</table>
		<?php if (!empty($bannedIps)): ?>
			<div>
				<?php echo __l('Select:'); ?>
				<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
			</div>
			<div class="js-pagination">
				<?php echo $this->element('paging_links'); ?>
			</div>
			<div class="admin-checkbox-button clearfix">
				<?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
			</div>
			<div class="hide">
				<?php echo $form->submit('Submit');  ?>
			</div>
		<?php endif; ?>
    <?php echo $form->end(); ?>
</div>