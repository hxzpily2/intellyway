<?php /* SVN: $Id: admin_index.ctp 42778 2011-01-29 11:12:54Z josephine_065at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userLogins index js-response js-responses">
    <h2><?php echo __l('User Logins');?></h2>
    <?php echo $form->create('UserLogin' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
		<?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
		<?php echo $form->submit(__l('Search'));?>
	<?php echo $form->end(); ?>
    <?php echo $form->create('UserLogin' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
    <?php echo $this->element('paging_counter');?>
    <div class="overflow-block">
    <table class="list">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Login Time'), 'UserLogin.created');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Username'), 'User.username');?></div></th>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Login IP'), 'UserLogin.user_login_ip');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('User Agent'), 'UserLogin.user_agent');?></div></th>
        </tr>
        <?php
        if (!empty($userLogins)):
            $i = 0;
            foreach ($userLogins as $userLogin):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td>
					<div class="actions-block">
						<div class="actions round-5-left">
							<span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userLogin['UserLogin']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
							<span>
							<?php echo $html->link(__l('Ban Login IP'), array('controller'=> 'banned_ips', 'action' => 'add', $userLogin['UserLogin']['user_login_ip']), array('class' => 'network-ip','title'=>__l('Ban Login IP'), 'escape' => false));?></span>
						</div>
					</div>
					<?php echo $form->input('UserLogin.'.$userLogin['UserLogin']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userLogin['UserLogin']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
                    <td><?php echo $html->cDateTimeHighlight($userLogin['UserLogin']['created']);?></td>
                    <td class="dl">
					<?php echo $html->getUserAvatarLink($userLogin['User'], 'micro_thumb',false);	?>
                    <?php echo $html->getUserLink($userLogin['User']);?></td>
					<td>
					<?php echo $html->cText($userLogin['UserLogin']['user_login_ip']);?>
                    <?php echo ' ['.$userLogin['UserLogin']['dns'].']' . '('. $html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $userLogin['UserLogin']['user_login_ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';?></td>
                    <td class="dl"><?php echo $html->cText($userLogin['UserLogin']['user_agent']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="6" class="notice"><?php echo __l('No User Logins available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    </div>

    <?php
    if (!empty($userLogins)) :
        ?>
        <div class="admin-select-block">
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
         <div class="admin-checkbox-button">
            <?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
         <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class = "hide">
            <?php echo $form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $form->end();
    ?>
</div>