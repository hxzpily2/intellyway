<?php /* SVN: $Id: admin_index.ctp 13910 2010-07-16 14:34:46Z siva_063at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userOpenids index js-response">
    <h2><?php echo __l('User Openids');?></h2>
   	<div><?php echo $html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add')));?></div>
    <?php echo $form->create('UserOpenid' , array('type' => 'get', 'class' => 'normal','action' => 'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $form->input('q', array('label' => __l('Keyword'))); ?>
		</div>
		<div>
			<?php echo $form->submit(__l('Search'));?>
		</div>
	</div>
	<?php echo $form->end(); ?>
    <?php echo $form->create('UserOpenid' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Username'), 'User.username');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('OpenID'), 'UserOpenid.openid');?></div></th>
        </tr>
        <?php
        if (!empty($userOpenids)):
            $i = 0;
            foreach ($userOpenids as $userOpenid):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td>
					<div class="actions-block">
						<div class="actions round-5-left">
							<span><?php echo $html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
						</div>
					</div>
					<?php echo $form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
                    <td class="dl"><?php echo $html->getUserLink($userOpenid['User']);?></td>
                    <td class="dl"><?php echo $html->cText($userOpenid['UserOpenid']['openid']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" class="notice"><?php echo __l('No User Openids available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    <?php
    if (!empty($userOpenids)) :
        ?>
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all')); ?>
            <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none')); ?>
        </div>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <div class=hide>
            <?php echo $form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $form->end();
    ?>
</div>