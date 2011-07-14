<?php /* SVN: $Id: admin_index.ctp 23765 2010-09-13 09:47:26Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<?php if(empty($this->params['isAjax']) && empty($this->params['named']['stat'])): ?>
	<div class="js-tabs">
		<ul class="clearfix">
            <li><?php echo $html->link(sprintf(__l('Pending (%s)'),$pending), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Pending), array('escape' => false, 'title' => __l('Pending'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Approved (%s)'),$approved), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Approved), array('escape' => false, 'title' => __l('Approved'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Rejected (%s)'),$rejected), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Rejected), array('escape' => false, 'title' => __l('Rejected'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Success (%s)'),$success), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Success), array('escape' => false, 'title' => __l('Success'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Failed (%s)'),$failed), array('controller' => 'user_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstWithdrawalStatus::Failed), array('escape' => false, 'title' => __l('Failed'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('All (%s)'),($approved + $pending + $rejected + $success + $failed)), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('escape' => false, 'title' => __l('All'))); ?></li>
        </ul>
    </div>
<?php else: ?>
    <div class="userCashWithdrawals index js-response">
    <h2><?php echo $pageTitle;?></h2>
    <?php echo $form->create('UserCashWithdrawal' , array('class' => 'normal','action' => 'update')); ?> <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?> <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
		    <?php if (!empty($userCashWithdrawals) && (empty($this->params['named']['filter_id']) || (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Approved && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Success && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Rejected))):?>
            <th>
                  <?php echo __l('Select'); ?>
            </th>
			<?php endif;?>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('User'),'User.username');?></div></th>
            <th class="dr"><div class="js-pagination"><?php echo $paginator->sort(__l('Amount'), 'UserCashWithdrawal.amount').' ('.Configure::read('site.currency').')';?> </div></th>
            <?php if(empty($this->params['named']['filter_id'])) { ?>
                <th><div class="js-pagination"><?php echo $paginator->sort(__l('Status'),'WithdrawalStatus.name');?></div></th>
            <?php } ?>
        </tr>
    <?php
    if (!empty($userCashWithdrawals)):
    
    $i = 0;
    foreach ($userCashWithdrawals as $userCashWithdrawal):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
		    <?php if (!empty($userCashWithdrawals) && (empty($this->params['named']['filter_id']) || (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Approved && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Success && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Rejected))):?>
			<td>
				<div class="actions-block">
					<div class="actions round-5-left">
						<span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userCashWithdrawal['UserCashWithdrawal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
					</div>
				</div>
                <?php echo $form->input('UserCashWithdrawal.'.$userCashWithdrawal['UserCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => false, 'class' => 'js-checkbox-list ' )); ?>
			</td>
			<?php endif;?>
            <td class="dl">
		    <?php if (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] == ConstWithdrawalStatus::Success || $this->params['named']['filter_id'] == ConstWithdrawalStatus::Rejected):?>
				<div class="actions-block">
					<div class="actions round-5-left">
						<span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userCashWithdrawal['UserCashWithdrawal']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
					</div>
				</div>
			<?php endif;?>
			<?php echo $html->getUserAvatarLink($userCashWithdrawal['User'], 'micro_thumb',false);	?>
            <?php echo $html->getUserLink($userCashWithdrawal['User']);?></td>
            <td class="dr"><?php echo $html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?></td>
            <?php if(empty($this->params['named']['filter_id'])) { ?>
                <td><?php echo $html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
            <?php } ?>
        </tr>
    <?php
        endforeach;
    else:
    ?>
        <tr>
            <td colspan="8" class="notice"><?php echo __l('No records available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    <?php if (!empty($userCashWithdrawals) && (empty($this->params['named']['filter_id']) || (!empty($this->params['named']['filter_id']) && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Approved && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Success && $this->params['named']['filter_id'] != ConstWithdrawalStatus::Rejected))):?>
		<div class="admin-select-block">
			<div>
				<?php echo __l('Select:'); ?>
				<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
				<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
			</div>
			<div class="admin-checkbox-button"><?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
		</div>
		<div class="hide"> <?php echo $form->submit('Submit');  ?> </div>
      <?php endif; ?>
			
    <?php
    if (!empty($userCashWithdrawals)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
      <?php echo $form->end(); ?>
    </div>
<?php endif; ?>