<?php /* SVN: $Id: admin_index.ctp 42428 2011-01-27 04:27:35Z usha_111at09 $ */ ?>
	<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>

<?php if(empty($this->params['isAjax'])): ?>
    <div  class="js-tabs">
    	<ul class="clearfix">
            <li><?php echo $html->link(sprintf(__l('Approved Records (%s)'),$approved), array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('title' => __l('Approved Records'))); ?></li>
            <li><?php echo $html->link(sprintf(__l('Disapproved Records (%s)'),$pending), array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('title' => __l('Disapproved Records'))) ?></li>
            <li><?php echo $html->link(sprintf(__l('Total Records (%s)'),($pending + $approved)), array('controller' => 'cities', 'action' => 'index'),array('title' => __l('Total Records'))) ?></li>
        </ul>
    </div>
<?php else: ?>
	<?php if(empty($this->data) && empty($this->params['named']['page'])): ?>
        <div class="cities index js-responses">
			<h2><?php echo $pageTitle; ?></h2>
            <?php echo $form->create('City', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form {"container" : "js-search-responses"}', 'action'=>'index')); ?>
            <div class="filter-section">
                <div>
                    <?php echo $form->input('q', array('label' => __l('Keyword')));
                          echo $form->input('filter_id', array('type' => 'hidden', 'value' => !empty($this->params['named']['filter_id'])?$this->params['named']['filter_id']:''));
                     ?>
                </div>
                <div class="submit-block">
                    <?php echo $form->submit(__l('Search'));?>
                </div>
            </div>
            <?php echo $form->end(); ?>
            <div class="add-block">
                <?php echo $html->link(__l('Add'),array('controller'=>'cities','action'=>'add'),array('class' => 'add', 'title' => __l('Add New City')));?>
            </div>
    <?php endif; ?>  
     <div class="js-search-responses js-response ">   
		<?php
        echo $form->create('City', array('action' => 'update','class'=>'normal')); ?>
        <?php echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url'])); ?>
        <?php if(!empty($this->params['named']['filter_id'])){?>
        <?php echo $form->input('redirect_url', array('type' => 'hidden', 'value' => $this->params['named']['filter_id'])); ?>
        <?php } ?>
        <?php echo $this->element('paging_counter');?>
        <table class="list">
            <tr>
                <th><?php echo __l('Select'); ?></th>
                <th><?php echo __l('Actions');?></th>
				<th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Name'), 'City.name');?></div></th>
                <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Country'), 'Country.name', array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>
                <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('State'), 'State.name', array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>
                <th class="dl"><div class="js-pagination"><?php echo $paginator->sort(__l('Language'), 'Language.name');?></div></th>               
                <th><div class="js-pagination"><?php echo $paginator->sort(__l('Active Deals'), 'City.active_deal_count');?></div></th>          
            </tr>
            <?php
            if (!empty($cities)):
                $i = 0;
                foreach ($cities as $city):
                    $class = null;
                    if ($i++ % 2 == 0) :
                        $class = ' class="altrow"';
                    endif;
                    if($city['City']['is_approved'])  :
                        $status_class = 'js-checkbox-active';
                    else:
                        $status_class = 'js-checkbox-inactive';
                    endif;
					$fb_city_login_url = $facebookObj->getLoginUrl(array('cancel_url' => Router::url(array('controller' => $city['City']['slug'], 'action' => 'cities', 'fb_update', 'admin' => false), true), 'next' => Router::url(array('controller' => $city['City']['slug'], 'action' => 'cities', 'fb_update', 'admin' => false), true), 'req_perms' => 'email,publish_stream'));
                ?>
                    <tr<?php echo $class;?>>
                        <td>
                            <div class="actions-block">
                                <div class="actions round-5-left cities-action-block">
                                <span>
									<?php 
										echo $html->link(__l('Edit'), array('action'=>'edit', $city['City']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));
                                        ?>
                                        </span>
                                           <span>
                                        <?php
                                    	if(Configure::read('site.city') != $city['City']['slug']):
											echo $html->link(__l('Delete'), array('action'=>'delete', $city['City']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete'))); 
										endif;
										?>
										</span>
										   <span>
										<?php
										echo $html->link(__l('Update Twitter Credentials'), array('action' => 'update_twitter', $city['City']['id']), array('class' => 'twitter-link', 'target' => '_blank', 'title' => __l('Update Twitter Credentials')));
                                    ?>
                                       </span>
                                          <span>
                                    <?php
                                    	echo $html->link(__l('Update').' '.__l('Facebook').' '.__l('Credentials'), $fb_city_login_url, array('class' => 'facebook-link', 'target' => '_blank', 'title' => __l('Update').' '.__l('Facebook').' '.__l('Credentials')));
									?>
									</span>
                                </div>
                            </div>
                            <?php
                                if($city['City']['slug'] != Configure::read('site.city')) :
                                    echo $form->input('City.'.$city['City']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$city['City']['id'],'label' => false , 'class' => $status_class.' js-checkbox-list'));
                                endif;
                            ?>
                        </td>
						<td class="<?php echo (Configure::read('site.city') != $city['City']['slug'])?'dl':'dl default';?>">
							<?php
							if(Configure::read('site.city') != $city['City']['slug']):
								if($city['City']['is_approved']):
									echo $html->link(__l('Approved'),array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'disapprove'),array('class' =>'approve','title' => __l('Click here to Disapprove')));
								else:
									echo $html->link(__l('Disapproved'),array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'approve') ,array('class' =>'pending','title' => __l('Click here to Approve')));
								  endif; 
							  endif;									  
							?>
						</td>
  						<td class="dl"><?php if(!empty($city['Attachment'])):
						  echo $html->showImage('City', $city['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($city['City']['name'], false)), 'title' => $html->cText($city['City']['name'], false)));
						  endif;?><span><?php echo $html->cText($city['City']['name'], false);
						?></span></td>
                        <td class="dl"><?php echo $html->cText($city['Country']['name'], false);?></td>
                        <td class="dl"><?php echo $html->cText($city['State']['name'], false);?></td>
                        <td class="dl"><?php echo !empty($city['Language']['name']) ? $html->cText($city['Language']['name'], false) : __l('N/A');?></td>
                        <td><?php echo $html->cInt($city['City']['active_deal_count']);?></td>
                     </tr>
                <?php
                endforeach;
                else:
                ?>
                <tr>
                    <td class="notice" colspan="10"><?php echo __l('No cities available');?></td>
                </tr>
                <?php
                endif;
                ?>
        </table>
		<?php
            if (!empty($cities)) :
                ?>
                 <div class="admin-select-block">
                <div>
                    <?php echo __l('Select:'); ?>
                    
                                <?php echo $html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
                                <?php echo $html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
                                 <?php if(!isset($this->params['named']['filter_id'])) { ?>
                                    <?php echo $html->link(__l('Disapproved'), '#', array('class' => 'js-admin-select-pending','title' => __l('Disapproved'))); ?>
                                    <?php echo $html->link(__l('Approved'), '#', array('class' => 'js-admin-select-approved','title' => __l('Approved'))); ?>
                                 <?php } ?>
                </div>
                   <div>
                    <?php echo $form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
                </div>
                </div>
                <div class="js-pagination">
                    <?php  echo $this->element('paging_links'); ?>
                </div>
             
                <div class="hide">
                    <?php echo $form->submit('Submit');  ?>
                </div>
                <?php
            endif;
        ?>
    <?
    echo $form->end();
    ?>
    </div>
<?php if(!empty($this->params['named']['main_filter_id']) && empty($this->params['named']['filter_id']) && empty($this->data)): ?>
	</div>
<?php endif; ?>

<?php endif; ?>