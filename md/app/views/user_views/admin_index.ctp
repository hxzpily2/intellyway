<?php /* SVN: $Id: admin_index.ctp 24496 2010-09-16 11:05:51Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userViews index js-response js-responses">
    <h2><?php echo __l('User Views');?></h2>
    <?php echo $form->create('UserView' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
			<?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $form->submit(__l('Search'));?>
	<?php echo $form->end(); ?>
    <?php echo $form->create('UserView' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th><?php echo __l('Select'); ?></th>            
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Viewed Time'),'UserView.created');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Username'), 'User.username');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Viewed User'), 'ViewingUser.username');?></div></th>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('IP'),'ip');?></div></th>
        </tr>
        <?php
        if (!empty($userViews)):
            $i = 0;
            foreach ($userViews as $userView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td>
					<div class="actions-block">
						<div class="actions round-5-left">
							 <span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userView['UserView']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>  
							 <span>
								<?php echo $html->link(__l('Ban User IP'), array('controller'=> 'banned_ips', 'action' => 'add', $userView['UserView']['ip']), array('class' => 'network-ip','title'=>__l('Ban User IP'), 'escape' => false));?>
							</span>
						</div>
					</div>
						 <?php echo $form->input('UserView.'.$userView['UserView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userView['UserView']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
					</td>                   
                    <td><?php echo $html->cDateTimeHighlight($userView['UserView']['created']);?></td>
                    <td>
					<?php echo $html->getUserAvatarLink($userView['User'], 'micro_thumb',false);	?>
                    <?php echo $html->getUserLink($userView['User']);?></td>
                    <td>
					<?php echo $html->getUserAvatarLink($userView['ViewingUser'], 'micro_thumb',false);	?>
					<?php echo !empty($userView['ViewingUser']['username']) ? $html->getUserLink($userView['ViewingUser']) : __l('Guest');?></td>
					<td>
					<?php echo $html->cText($userView['UserView']['ip']);?>
					<?php echo ' ['.$userView['UserView']['dns'].']' . '('. $html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $userView['UserView']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7" class="notice"><?php echo __l('No User Views available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>

    <?php
    if (!empty($userViews)) :
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
        <div class="hide">
            <?php echo $form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $form->end();
    ?>
</div>