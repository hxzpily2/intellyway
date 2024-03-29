<?php /* SVN: $Id: admin_index.ctp 13910 2010-07-16 14:34:46Z siva_063at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="languages index">
	<?php if(empty($this->params['isAjax'])) { ?>
	   <h2><?php echo $pageTitle;?></h2>
	<div  class="js-tabs">
		<ul class="clearfix">
            <li><?php echo $html->link(sprintf(__l('Active Records (%s)'),$approved), array('controller' => 'languages', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('title' => __l('Approved Records'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Inactive Records (%s)'),$pending), array('controller' => 'languages', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('title' => __l('Disapproved Records'))) ?></li>
            <li><?php echo $html->link(sprintf(__l('Total Records (%s)'),($pending + $approved)), array('controller' => 'languages', 'action' => 'index'),array('title' => __l('Total Records'))) ?></li>
        </ul>
    </div>
	<?php }
		  else {?>
    <div class="js-response js-response js-responses js-search-responses">
        <?php       echo $form->create('Language', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form {"container" : "js-search-responses"}', 'action'=>'index'));
                      echo $form->input('q', array('label' => __l('Keyword')));
                      echo $form->input('filter_id', array('type' => 'hidden', 'value' => !empty($this->params['named']['filter_id'])?$this->params['named']['filter_id']:''));
                      echo $form->submit(__l('Search'));
                      echo $form->end();
                ?>
		<div class="clearfix add-block1">
    		<?php echo $html->link(__l('Add'), array('controller' => 'languages', 'action' => 'add'), array('class' => 'add', 'title' => __l('Add'), 'escape' => false)); ?>
         </div>
    <?php echo $form->create('Language' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
    <?php if(!empty($this->params['named']['filter_id'])){?>
    <?php echo $form->input('redirect_url', array('type' => 'hidden', 'value' => $this->params['named']['filter_id'])); ?>
    <?php } ?>
    <?php echo $this->element('paging_counter');?>
    
    <table class="list">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Name'), 'Language.name');?></div></th>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('ISO2'), 'Language.iso2');?></div></th>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('ISO3'), 'Language.iso3');?></div></th>
			<?php if(!isset($this->params['named']['filter_id'])) {?>
            <th><div class="js-pagination"><?php echo $paginator->sort(__l('Status'), 'Language.is_active'); ?></div></th>
            <?php } ?>
        </tr>
         <?php
            if (!empty($languages)):
                $i = 0;
				foreach ($languages as $language):
                    $class = null;
                    if ($i++ % 2 == 0) :
                        $class = ' class="altrow"';
                    endif;
                    if($language['Language']['is_active'])  :
                        $status_class = 'js-checkbox-active';
                    else:
                        $status_class = 'js-checkbox-inactive';
                    endif;
                ?>
		

                <tr<?php echo $class;?>>
                    <td>
                        <div class="actions-block">
                            <div class="actions round-5-left">
								  <?php echo $html->link(__l('Edit'), array('action'=>'edit', $language['Language']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
                             </div>
                        </div>
					 <?php echo $form->input('Language.'.$language['Language']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$language['Language']['id'],'label' => false , 'class' => $status_class.' js-checkbox-list'));?></td>
                    <td class="dl"><?php echo $html->cText($language['Language']['name']);?></td>
                    <td><?php echo $html->cText($language['Language']['iso2']);?></td>
                    <td><?php echo $html->cText($language['Language']['iso3']);?></td>
					<?php if(!isset($this->params['named']['filter_id'])) {?>
                    <td><?php echo ($language['Language']['is_active']) ? __l('Active') : __l('Inactive'); ?></td>
                    <?php } ?>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="5" class="notice"><?php echo __l('No Languages available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    
    <?php
    if (!empty($languages)) :
        ?>
          <div class="admin-select-block">
            <div>
        		<?php echo __l('Select:'); ?>
    			<?php if(isset($this->params['named']['filter_id'])) {?>
        		<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
        		<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
    			<?php }
    				  else { ?>
        		<?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
        		<?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
        		<?php echo $html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Inactive'))); ?>
        		<?php echo $html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
                <?php } ?>
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
    	  <?php }?>
     </div>