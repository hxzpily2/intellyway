<?php
$javascript->link('libs/divs', false);
?>
<?php /* SVN: $Id: view.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<?php if($this->params['action'] !='index'):
	if($html->isAllowed($auth->user('user_type_id')) and   $deal['Deal']['deal_status_id'] != ConstDealStatus::Open && $deal['Deal']['deal_status_id'] != ConstDealStatus::Tipped && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval  && $deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming ):?>
		<div id="missed_deal_announcement" style="display: none;">
			  <!-- <p id="txt_missed_groupon">
				<?php echo __l('Oh no... You\'re too late for this ').' '.Configure::read('site.name').'!';?>
				
			  </p> -->	
			  	<div id="md_too_late">&nbsp;</div>				  		  
			  	<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr height="100">
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<div id="blockui_close" onclick="javascript:$.unblockUI();">&nbsp;</div>
							<h3 class="bought">
								<?php echo __l('Oh no... You\'re too late for this ').' '.Configure::read('site.name').'!';?>
							</h3>							
							<p class="blocksignup">							
							<?php echo __l('Sign up for our daily email so you never miss another').' '.Configure::read('site.name').'!';?>
							</p>
							<div class="right">
			 				<?php echo $this->element('../subscriptions/add', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
			 				</div>												
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>			  
	 </div>
	 <script type="text/javascript">
	 	$(window).load(function() {
		 	$.blockUI({ 
			 	centerX: false, 
		 	    centerY: false,
			 	css: {      
						margin : 'auto',
		            	width: '500px',
			            height: 'auto',
			            cursor: 'null',
			            border: 'none',
			            textalign: 'center',
			            backgroundColor: 'auto', 
			    }, 
		 	    message: $('#missed_deal_announcement')
		 	 });
		});
	 	
	 </script>
	<?php endif; ?>
<?php endif; ?>	
	<div id="deal_friends">
		<div style="display:inline;"><?php echo $html->image('deal_friends_'.Configure::read('lang_code').'.png'); ?></div>
		<div style="display:inline;width:10px;">&nbsp;</div>	
		<div style="display:inline;" id="sharemail">
			<a target="blank" title="<?php echo __l('Send a mail to friend about this deal'); ?>" href="<?php echo 'mailto:?body='.__l('Check out the great deal on ').Configure::read('site.name').' - '.Router::url('/', true).'deal/'.$deal['Deal']['slug'].'&amp;subject='.__l('I think you should get ').Configure::read('site.name').__l(': ').$deal['Deal']['discount_percentage'].__l('% off at ').$deal['Company']['name']; ?>"><?php echo $html->image('mail_icon.png'); ?></a>			
		</div>
		<div style="display:inline;" id="share">			
			<fb:share-button class="meta">
				<meta name="title" content="HyperArts"/>			
				<meta name="description" content="Read the Static FBML Bible and Rejoice!"/>			
				<link rel="image_src" href="http://www.hyperarts.com/facebook/static-fbml-bible/_img/share-popup_80x80.gif"/>			
				<link rel="target_url" href="http://www.facebook.com/StaticFBMLBible"/>			
			</fb:share-button>
		</div>
		<!-- <div style="display:inline;"><?php echo $html->image('twitter_icon.png'); ?></div> -->
		<div style="display:inline;width:10px;">&nbsp;</div>
	</div>
    <div class="deal-view-inner-block clearfix">
    <div class="main-shad">&nbsp;</div>
      <div id="md_deal_global_infos">
      	<div id="md_deal_infos">
      		<div class="tag_pourcent"><div class="pourcent_tag"><center><span>&#45; <?php echo round($deal['Deal']['discount_percentage']) . "&#37;"; ?></span></center></div></div>
      		<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr height="20">
					<td width="27" id="md_deal_infos_top_left">&nbsp;</td>
			   	    <td id="md_deal_infos_top">&nbsp;</td>
					<td id="md_deal_infos_top_right" width="21">&nbsp;</td>
				</tr>
				<tr height="300">
					<td id="md_deal_infos_left" width="27">&nbsp;</td>
					<td id="md_deal_infos_texture">
						<!-- BEGIN CONTENT -->
						<div class="title">
		        			<span class ="today-deal">
		        				<!--
		        				<?php if($this->params['action'] =='index'):?>
		        					<?php	echo __l("Today's Deal").': ';?>
		        				<?php endif; ?>
		        				-->
		        			</span>
		            		<!--<?php
		            			echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));
		            		?>-->		            		
		            		<table width="648" height="320">
								<tr height="18">
									<td width="20" id="desc_top_left">&nbsp;</td>
									<td id="desc_top">&nbsp;</td>
									<td width="20" id="desc_top_right">&nbsp;</td>
								</tr>
								<tr>
									<td width="20" id="desc_left">&nbsp;</td>
									<td id="desc_texture">
										<!-- SLIDESHOW -->
					            		<?php
					            			$images = $deal['Attachment'];
					            			$name = $deal['Deal']['name'];
					            			echo $this->element("slideshow",array("IMAGES"=>$images,"ID"=>$deal['Deal']['id'],"DEAL"=>$deal['Deal']));
					            		?>					            		
									</td>
									<td width="20" id="desc_right">&nbsp;</td>
								</tr>
								<tr height="21">
									<td width="20" id="desc_bottom_left">&nbsp;</td>
									<td id="desc_bottom">&nbsp;</td>
									<td width="20" id="desc_bottom_right">&nbsp;</td>
								</tr>
							</table>														
			           	</div>
			           				           	
			           	<div id="desc_div_left">
			           		<table width="100%" height="320">
								<tr height="18">
									<td width="20" id="desc_top_left">&nbsp;</td>
									<td id="desc_top">&nbsp;</td>
									<td width="20" id="desc_top_right">&nbsp;</td>
								</tr>
								<tr>
									<td width="20" id="desc_left">&nbsp;</td>
									<td id="desc_texture">
										<div id="highlights_div">
											<div id="fine-print-block">
						                        <h3><?php echo __l('The Fine Print');?></h3>
						                        <?php if(!empty($deal['Deal']['coupon_expiry_date'])){
								                 		 echo __l('Expires '); 
								                         echo  $html->cDateTime($deal['Deal']['coupon_expiry_date']);
													  }	  
													  echo ' '.$html->cHtml($deal['Deal']['coupon_condition']);
												?>
						                        <?php echo $html->link(__l('Read the Deal FAQ'), array('controller' => 'pages', 'action' => 'view','faq', 'admin' => false), array('target'=>'_blank', 'title' => __l('Read the deal FAQ')));?> <?php echo __l(' for the basics.'); ?>
						                    </div>
						                    <div id="highlight-block">
						                      <h3><?php echo __l('Highlights');?></h3>
						                      <?php echo $html->cHtml($deal['Deal']['coupon_highlights']);?>
						                    </div>
										</div>	
										<div id="descr_sep"><center><?php echo $html->image('md_price_sep.png'); ?></center></div>									
										<!-- DESCRIPTION -->
										
					            		<h3><?php echo __l('Description');?></h3>
                    					<?php echo $html->cHtml($deal['Deal']['description']);?>
                    					
                    					<!-- REVIEWS -->
                    					
                    					<?php if(!empty($deal['Deal']['review'])){?>
                    						<div id="descr_sep"><center><?php echo $html->image('md_price_sep.png'); ?></center></div>	
					        				<h3><?php echo __l('Reviews');?></h3>
					        				<div class="big-text"><?php echo $html->cHtml($deal['Deal']['review']);?></div>
									    <?php }?>
									    
									    <!-- COMMENT -->
									    <?php if(!empty($deal['Deal']['comment'])) {?>
									    	<div id="descr_sep"><center><?php echo $html->image('md_price_sep.png'); ?></center></div>
											<h3><?php echo Configure::read('site.name').' '.__l('says');?></h3>
					                       	<?php echo $html->cHtml($deal['Deal']['comment']);?>
					                    <?php } ?>
					                    
					                    
									</td>
									<td width="20" id="desc_right">&nbsp;</td>
								</tr>
								<tr height="21">
									<td width="20" id="desc_bottom_left">&nbsp;</td>
									<td id="desc_bottom">&nbsp;</td>
									<td width="20" id="desc_bottom_right">&nbsp;</td>
								</tr>
							</table>
			           	</div>
			           	<div id="desc_div_right">
			           		<table width="100%" height="320">
								<tr height="18">
									<td width="20" id="desc_top_left">&nbsp;</td>
									<td id="desc_top">&nbsp;</td>
									<td width="20" id="desc_top_right">&nbsp;</td>
								</tr>
								<tr>
									<td width="20" id="desc_left">&nbsp;</td>
									<td id="desc_texture">
										<h3><div id="icon_gmap"><?php echo $html->image('my_custom_icon.png',array('width'=>'15')); ?></div><?php echo __l('Company Info:');?></h3>
					                    <h5 class="big"><?php
					        					if($deal['Company']['is_company_profile_enabled'] && $deal['Company']['is_online_account']):
					        						echo $html->link($html->cText($deal['Company']['name']), array('controller' => 'companies', 'action' => 'view',   $deal['Company']['slug']),array('title' =>$html->cText($deal['Company']['name'],false)), null, false);
					        					else:
					        						echo $html->cText($deal['Company']['name']);
					        					endif;
					
					        			?></h5>
					                    <?php if(!empty($deal['Company']['url'])): ?>
					                        <a href="<?php echo $deal['Company']['url'];?>" title="<?php echo $html->cText($deal['Company']['url'],false);?>" target="_blank"><?php echo $html->cText($deal['Company']['url'],false);?></a>
					                    <?php endif; ?>
					                    <address>
					                    <?php echo $html->cText($deal['Company']['address1']);?>
					                    <?php echo !empty($deal['Company']['City']['name']) ? $html->cText($deal['Company']['City']['name']) : '';?><?php echo !empty($deal['Company']['State']['name']) ? $html->cText($deal['Company']['State']['name']) : '';?> <?php echo $html->cText($deal['Company']['zip']);?>
					                    </address>
					        			<?php if(!empty($deal['Company']['CompanyAddress'])):?>
					        			<div class="map-info-r">
					        				<p class="big">
					        					<span>
					        						<?php echo __l('Branch Addresses');?>
					        					</span>
					        				</p>
					    				<ol class="address-list clearfix">
					    					<?php foreach($deal['Company']['CompanyAddress'] as $address): ?>
					    						<li>
					    							<address class="address<?php echo $count;?>">
					    								<?php if (!empty($address['address1']) || !empty($address['address2'])): ?>
					    									<span class="street-name"><?php echo ((!empty($address['address1'])) ? $address['address1'] : '') . ' ' . ((!empty($address['address2'])) ? $address['address2'] : ''); ?></span>
					    								<?php endif; ?>
					    								<?php if (!empty($address['City']['name']) || !empty($address['State']['name'])): ?>
					    									<span><?php echo (!empty($address['City']['name'])) ? $address['City']['name'] . ', ' : ''; ?> <?php echo (!empty($address['State']['name'])) ? $address['State']['name'] : ''; ?></span>
															<span><?php echo (!empty($address['Country']['name'])) ? $address['Country']['name'] : ''; ?></span>
					    								<?php endif; ?>
					    								<?php if (!empty($address['zip'])): ?>
					    									<span><?php echo $address['zip']; ?></span>
					    								<?php endif; ?>
					    							</address>
					    						</li>
					    					<?php endforeach; ?>
					    				</ol>
								</div>
					     		 <?php endif; ?>
										<?php if($deal['Company']['is_company_profile_enabled'] == 1):?>
					                    <?php			           	
			            				$company = $deal['Company'];			            				
			            				$zoom = Configure::read('GoogleMap.static_map_zoom_level');
						           		?>
						           		<?php echo $this->element("gmap",array("ID"=>$deal['Deal']['id'],"COMPANY"=>$company,"ZOOM"=>$zoom));?>
										<?php endif; ?>
					                    
									</td>
									<td width="20" id="desc_right">&nbsp;</td>
								</tr>
								<tr height="21">
									<td width="20" id="desc_bottom_left">&nbsp;</td>
									<td id="desc_bottom">&nbsp;</td>
									<td width="20" id="desc_bottom_right">&nbsp;</td>
								</tr>
							</table>
			           	</div>
			           	
			           	<!-- END CONTENT -->
					</td>
					<td id="md_deal_infos_right" width="21">&nbsp;</td>
				</tr>
				<tr height="20">
					<td width="27" id="md_deal_infos_bottom_left">&nbsp;</td>
					<td id="md_deal_infos_bottom">&nbsp;</td>
					<td width="21" id="md_deal_infos_bottom_right">&nbsp;</td>
				</tr>
			</table>
			
			<!-- POSTS -->
			<br/>
			<h2 style="font-size: 22pt">Commentaires</h2>
			<br/>
			<?php 
			$discuss = $mdtopicdiscussions[$deal['Deal']['id']];
			//print_r($discuss);
			$isPair = 0; 
			foreach ($discuss as $discus): 
			?>			
			<table width="100%">
				<tr height="25">
					<td width="15" id="cmt_top_left">&nbsp;</td>
					<td colspan="2" id="cmt_top">&nbsp;</td>
					<td width="15" id="cmt_top_right">&nbsp;</td>
				</tr>
				<tr>
					<td width="15" id="cmt_middle_left">&nbsp;</td>
					<td colspan="2" id="cmt_middle"><span class="spncmttxt"><?php echo $discus['TopicDiscussion']['comment']; ?></span></td>
					<td width="15" id="cmt_middle_right">&nbsp;</td>
				</tr>
				<?php if($isPair%2==0): ?>
				<tr height="25">
					<td width="15" id="cmt_bottom_left">&nbsp;</td>
					<td width="17" id="cmt_bulle">&nbsp;</td>
					<td id="cmt_bottom">&nbsp;</td>
					<td width="15" id="cmt_bottom_right">&nbsp;</td>
				</tr>
				<tr height="40">
					<td colspan="4" align="left" style="padding-left: 15px;"  valign="middle">
						<?php
							$cmt_user_details = array(
								'username' => $discus['TopicDiscussion']['username'],
								'user_type_id' =>  $discus['TopicDiscussion']['user_type_id'],
								'id' =>  $discus['TopicDiscussion']['user_id'],
								'fb_user_id' =>  $discus['TopicDiscussion']['fb_user_id']
							);
														
    						$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
    						echo $html->getUserCmtAvatarLink($cmt_user_details, 'small_thumb');
    					?>
    					<span class="spncmtuser"><?php echo $discus['TopicDiscussion']['username']; ?></span>
    					<span class="spndatecmtuser">(<?php echo date("d/m/Y h:i:s",strtotime($discus['TopicDiscussion']['created'])); ?>)</span>
					</td>
				</tr>
				<?php else:?>
				<tr height="25">
					<td width="15" id="cmt_bottom_left">&nbsp;</td>					
					<td id="cmt_bottom">&nbsp;</td>
					<td width="17" id="cmt_bulle_inv">&nbsp;</td>
					<td width="15" id="cmt_bottom_right">&nbsp;</td>
				</tr>
				<tr height="40">
					<td colspan="4" align="right" style="padding-right: 15px;"  valign="middle">						    					
    					<span class="spndatecmtuser">(<?php echo date("d/m/Y h:i:s",strtotime($discus['TopicDiscussion']['created'])); ?>)</span>
    					<span class="spncmtuser"><?php echo $discus['TopicDiscussion']['username']; ?></span>
    					<?php
							$cmt_user_details = array(
								'username' => $discus['TopicDiscussion']['username'],
								'user_type_id' =>  $discus['TopicDiscussion']['user_type_id'],
								'id' =>  $discus['TopicDiscussion']['user_id'],
								'fb_user_id' =>  $discus['TopicDiscussion']['fb_user_id']
							);
														
    						$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
    						echo $html->getUserCmtAvatarLink($cmt_user_details, 'small_thumb');
    					?>
					</td>
				</tr>
				<?php endif;?>
			</table>
			<?php 
				$isPair++;
			endforeach;
			?>
			<table width="100%" height="175">
				<tr height="25">
					<td width="15" id="cmt_top_left">&nbsp;</td>
					<td colspan="2" id="cmt_top">&nbsp;</td>
					<td width="15" id="cmt_top_right">&nbsp;</td>
				</tr>
				<tr>
					<td width="15" id="cmt_middle_left">&nbsp;</td>
					<td colspan="2" id="cmt_middle">
						<div class="posts_textarea">							
							<?php $mdtopic = $mdtopics[$deal['Deal']['id']]; ?>
							<?php echo $form->create('Deal', array('action' => 'add_comment', 'enctype' => 'multipart/form-data')); ?> 							
								<?php echo $form->input('mdtopicid', array('type' => 'hidden','value'=>$mdtopic['Topic']['id']));?>
								<?php echo $form->textarea('user_post_ta'); ?>				        		
				        		<br/>
				        		<br style="line-height: 10px;"/>
				        		<a class="blue_button" style="float:right;margin-right:-2px;" onclick="$('form').submit()" href="#"><span><?php echo __l('Submit'); ?></span></a>
			        		<?php echo $form->end(); ?>        		
			        	</div>
					</td>
					<td width="15" id="cmt_middle_right">&nbsp;</td>
				</tr>
				<?php if($isPair%2==0): ?>
				<tr height="25">
					<td width="15" id="cmt_bottom_left">&nbsp;</td>
					<td width="17" id="cmt_bulle">&nbsp;</td>
					<td id="cmt_bottom">&nbsp;</td>
					<td width="15" id="cmt_bottom_right">&nbsp;</td>
				</tr>
				<tr height="40">
						<td colspan="4" align="left" style="padding-left: 15px;">
							<?php
								$current_user_details = array(
									'username' => $auth->user('username'),
									'user_type_id' =>  $auth->user('user_type_id'),
									'id' =>  $auth->user('id'),
									'fb_user_id' =>  $auth->user('fb_user_id')
								);															
	    						$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
	    						echo $html->getUserCmtAvatarLink($current_user_details, 'small_thumb');
	    					?>
	    					<span class="spncmtuser"><?php echo  $auth->user('username'); ?></span>
						</td>
					
						
				<?php else:?>
				<tr height="25">
					<td width="15" id="cmt_bottom_left">&nbsp;</td>					
					<td id="cmt_bottom">&nbsp;</td>
					<td width="17" id="cmt_bulle_inv">&nbsp;</td>
					<td width="15" id="cmt_bottom_right">&nbsp;</td>
				</tr>
				<tr height="40">	
					<td colspan="4" align="right" style="padding-right: 15px;" >
							<span class="spncmtuser"><?php echo  $auth->user('username'); ?></span>
							<?php
								$current_user_details = array(
									'username' => $auth->user('username'),
									'user_type_id' =>  $auth->user('user_type_id'),
									'id' =>  $auth->user('id'),
									'fb_user_id' =>  $auth->user('fb_user_id')
								);															
	    						$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
	    						echo $html->getUserCmtAvatarLink($current_user_details, 'small_thumb');
	    					?>
						</td>
					
				</tr>
				<?php endif;?>
			</table>
			<!-- <table width="100%" height="175">
				<tr height="18">
					<td width="20" id="desc_top_left">&nbsp;</td>
					<td id="desc_top">&nbsp;</td>
					<td width="20" id="desc_top_right">&nbsp;</td>
				</tr>
				<tr>
					<td width="20" id="desc_left">&nbsp;</td>
					<td id="desc_texture">
						<div class="posts_textarea">
			        		<textarea id="user_post_ta"></textarea>
			        		<br/>
			        		<br style="line-height: 10px;"/>
			        		<a class="blue_button" style="float:right;margin-right:-2px;" onclick="javascript:postComment();" href="#"><span><?php echo __l('Submit'); ?></span></a>        		
			        	</div>
					</td>
					<td width="20" id="desc_right">&nbsp;</td>
				</tr>
				<tr height="21">
					<td width="20" id="desc_bottom_left">&nbsp;</td>
					<td id="desc_bottom">&nbsp;</td>
					<td width="20" id="desc_bottom_right">&nbsp;</td>
				</tr>
			</table> -->		
			<!--			
			<div class="posts_textarea">
        		<textarea id="user_post_ta"></textarea>
        		<br/>
        		<br style="line-height: 10px;"/>
        		<a class="blue_button" style="float:right;margin-right:-2px;" onclick="javascript:postComment();" href="#"><span><?php echo __l('Submit'); ?></span></a>        		
        	</div>
        	<div class="posts">
        		        		
        	</div>
        	 -->
        	<!-- BEGIN DISQUS 
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr height="20">
					<td width="27" id="md_deal_infos_top_left">&nbsp;</td>
			   	    <td id="md_deal_infos_top">&nbsp;</td>
					<td id="md_deal_infos_top_right" width="21">&nbsp;</td>
				</tr>
				<tr height="300">
					<td id="md_deal_infos_left" width="27">&nbsp;</td>
					<td id="md_deal_infos_texture" style="padding-top: 10px;padding-bottom: 10px;padding-right: 5px;">
						<table width="100%" height="320">
								<tr height="18">
									<td width="20" id="desc_top_left">&nbsp;</td>
									<td id="desc_top">&nbsp;</td>
									<td width="20" id="desc_top_right">&nbsp;</td>
								</tr>
								<tr>
									<td width="20" id="desc_left">&nbsp;</td>
									<td id="desc_texture">										
										
										<div id="disqus_thread"></div>
										<?php
											echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));
										?>
										<script type="text/javascript">
										    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
										    var disqus_shortname = 'missdeal'; // required: replace example with your forum shortname
											var disqus_identifier = 'dd';
										    /* * * DON'T EDIT BELOW THIS LINE * * */
										    (function() {
										        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
										        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
										        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
										    })();
										</script>
										<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>									
										
									</td>
									<td width="20" id="desc_right">&nbsp;</td>
								</tr>
								<tr height="21">
									<td width="20" id="desc_bottom_left">&nbsp;</td>
									<td id="desc_bottom">&nbsp;</td>
									<td width="20" id="desc_bottom_right">&nbsp;</td>
								</tr>
						</table>			
					</td>
					<td id="md_deal_infos_right" width="27">&nbsp;</td>
				</tr>
				<tr height="20">
					<td width="27" id="md_deal_infos_bottom_left">&nbsp;</td>
					<td id="md_deal_infos_bottom">&nbsp;</td>
					<td width="21" id="md_deal_infos_bottom_right">&nbsp;</td>
				</tr>	
			</table>
			<!-- END DISQUS -->			
			<!--<div class="posts_textarea">
        		<textarea id="user_post_ta"></textarea>
        		<br/>
        		<br style="line-height: 10px;"/>
        		<a class="blue_button" style="float:right;margin-right:-2px;" onclick="javascript:postComment();" href="#"><span><?php echo __l('Submit'); ?></span></a>        		
        	</div>
        	<div class="posts">
        		        		
        	</div>-->
      	</div>
      	<div id="md_right_block">
      		<div id="md_price_economie_block">
      			
      		</div>      		
      		<div id="md_price_block">
      			<div id="md_price_value">
      				<p class="price"><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price']));?></p>
      				<p class="oldprice">
      				<?php $old_price = $deal['Deal']['discounted_price'] + $deal['Deal']['savings']; ?>
      					<?php echo $html->siteCurrencyFormat($html->cCurrency($old_price));?>
      					<span id="price_barre">&nbsp;</span>
      				</p>
      			</div>
      			<br/>     			
      			<div id="md_price_buy_button">
      				<?php //$deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming
						if($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval):
							if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped):
								 echo $html->link($html->image('button_buy_'.Configure::read('lang_code').'.png',array('title' => __l('Buy Now'))), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id']), array('escape' => false,'class'=>''));								 
							elseif($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] == ConstDealStatus::Upcoming):
							?>
								<?php echo $html->image('button_buy_'.Configure::read('lang_code').'.png'); ?>
							<?php
								else:
							?>
								<?php echo $html->image('button_buy_'.Configure::read('lang_code').'.png'); ?>
							<?php
							endif;
						endif;
	                ?>
      			</div>
      		</div>
      		<div id="md_price_sep_time_to_left" class="md_price_sep">&nbsp;</div>
      		<div id="md_time_left_to_buy">
      			<?php echo __l('Time left to buy');?> :
      		</div>
      		
  			<?php if(($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped)): 
					if(empty($deal['Deal']['is_anytime_deal'])){
			?>
			<?php echo $this->element("counter",array("ID"=>$deal['Deal']['id'],"END"=>$deal['Deal']['end_date']));?>
			<?php }else{ ?>
				<div id="md_unlimited_<?php echo Configure::read('lang_code'); ?>">&nbsp;</div>
			<?php } ?>
			<?php elseif ($deal['Deal']['deal_status_id'] == ConstDealStatus::Upcoming) :?>
				<div id="md_bientot_<?php echo Configure::read('lang_code'); ?>">&nbsp;</div>
			<?php else :?>	
				<div id="md_indisponible_<?php echo Configure::read('lang_code'); ?>">&nbsp;</div>
  			<?php endif; ?>
      			
      		<div id="md_price_sep_counter" class="md_price_sep">&nbsp;</div>
      		<div id="md_nb_vendu"> 
      			<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open) : ?> 
      				<div class="price_block"><center><h3 class="bought"><?php echo $html->cInt($deal['Deal']['deal_user_count']);?> <?php echo __l('Bought');?></h3></center></div>
      				<?php $pixels = round(($deal['Deal']['deal_user_count']/$deal['Deal']['min_limit']) * 100); ?>    			                 
      				<?php echo $html->image('md_vendu_'.$pixels.'.png'); ?>
      				<div style="height:10px;">&nbsp;</div>      				      				
      				<div class="price_block"><center><span class="progress-needed"><?php echo sprintf(__l('<b>%s</b> more needed to get the deal'),($deal['Deal']['min_limit'] - $deal['Deal']['deal_user_count'])) ?></span></center></div>
      			<?php endif; ?>
      			<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped || $deal['Deal']['deal_status_id'] == ConstDealStatus::Closed): ?>                    
                    	<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped): ?>
                        <div class="price_block"><center><h3 class="bought2"><span><?php echo $html->image('deal_on.png'); ?></span>&nbsp;<?php echo __l('The deal is on!'); ?></h3></center></div>
                        <!--<p> <?php echo __l('Get in quick or miss out!');?> </p>-->
                        <?php endif; ?>
                        <div class="price_block"><center><span class="progress-needed"><?php echo sprintf(__l('Tipped at %s with <b>%s</b> bought'),$html->cDateTime($deal['Deal']['deal_tipped_time']),$html->cInt($deal['Deal']['min_limit']));?></span></center></div>                       
                        <div class="price_block"><center><span class="progress-needed2"><?php echo $html->cInt($deal['Deal']['deal_user_count']);?> <?php echo __l('offers sold so far');?></span></center></div>
				<?php endif; ?>                             
      		</div>
      		<div id="md_offer">
      			<center><span><?php echo $html->image('present.png'); ?></span>&nbsp;      			
      			<?php echo $html->link(__l('Buy it for a friend!'), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id'],'type' => 'gift'), array('title' => __l('Buy it for a friend')));?></center>      			
      		</div>
      		<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr height="20">
					<td id="md_deal_price_top_left" width="17">&nbsp;</td>
			   	    <td id="md_deal_price_top" >&nbsp;</td>
					<td id="md_deal_price_top_right" width="18">&nbsp;</td>
				</tr>
				<tr height="530">
					<td id="md_deal_price_left" width="17">&nbsp;</td>
					<td id="md_deal_price_texture" >						
						&nbsp;						
					</td>
					<td id="md_deal_price_right" width="18">&nbsp;</td>
				</tr>
				<tr height="20">
					<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
					<td id="md_deal_price_bottom">&nbsp;</td>
					<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
				</tr>
			</table>
			<!-- BEGIN SIDE BLOCK -->
			<?php if(Configure::read('deal.voyage')=='ON'){ ?>
			<!-- SPECIAL VOYAGE -->
			<div style="height:10px;">&nbsp;</div>
			<div id="travel">
				<?php echo $html->link($html->image('special_voyage_'.Configure::read('lang_code').'.png',array('title' => __l('Special Trips'))), array('controller' => 'deals', 'action' => 'index', 'admin' => false, 'type' => 'recent',ConstMissdealSpecialType::PARAM=>ConstMissdealSpecialType::TRAVEL), array('escape' => false,'class'=>''));?>				
			</div>
			<?php } ?>	
			
			<?php if(Configure::read('deal.is_side_deal_enabled') && !empty($side_deals)): ?>
			<!-- DEAL SIDE BAR -->
			<div style="height:10px;">&nbsp;</div>
			<div id="dealside">
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr>
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<div style="height: 3px;">&nbsp;</div>
							<?php
							$i=0;
		                	foreach($side_deals as $side_deal):
								?>
								<span class="aulieu">
									<?php echo $html->siteCurrencyFormat($html->cCurrency($side_deal['Deal']['discounted_price']));?>
									<?php echo __l("for"); ?>
									<?php echo $html->siteCurrencyFormat($html->cCurrency($side_deal['Deal']['original_price']));?>
								</span><br/>
								<span class="sidebar_h4"><?php echo $html->link($side_deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$side_deal['Deal']['name'])));?></span>
								<div style="height: 5px;">&nbsp;</div>
								<div style="position: relative;">
									<!-- <div class="deal1-value-<?php echo (($i%2==0)?"pair":"impair"); ?>">
										<div>
											
											<?php if($side_deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped): ?>											
											<span><?php echo $html->image('deal_on.png',array('style'=>'width:13px;')); ?></span>
											<?php endif; ?>																					
											<?php if($side_deal['Deal']['deal_status_id'] == ConstDealStatus::Open): ?>											
											<span><?php echo $html->image('deal_open.png',array('style'=>'')); ?></span>
											<?php endif; ?>
											<span style="color: #ffe7eb;text-shadow: black 0.1em 0.1em 0.2em;text-decoration: none;">
												<?php echo $html->cInt($side_deal['Deal']['deal_user_count']);?>
												<?php echo __l('Bought');?>
											</span>																					
										</div>
										<div style="height: 3px;">&nbsp;</div>					                    
					                    <div>							
											<?php echo $html->link($html->tag('span', __l('View it'), array('class' => '')), array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('escape'=>false,'class'=>'blue_button')); ?>
										</div>
									</div> -->
									
									<div class="deal1-img-<?php echo (($i%2==0)?"pair":"impair"); ?>">										
										<?php echo $html->link($html->showImage('Deal', $side_deal['Attachment'][0], array('dimension' => 'small_big_thumb','class'=>'img1', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($side_deal['Deal']['name'], false)), 'title' => $html->cText($side_deal['Deal']['name'], false))), array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$side_deal['Deal']['name'])), null, false);?>
										<div class="sidedeal-example">
											<div class="sidedeal-example1">
												<?php echo $html->link($html->tag('span', __l('View it'), array('class' => '')), array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('escape'=>false,'class'=>'pink_button')); ?>
											</div>	
											<div class="sidedeal-example2">	
												<?php if($side_deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped): ?>											
												<span><?php echo $html->image('deal_on.png',array('style'=>'width:13px;')); ?></span>
												<?php endif; ?>																					
												<?php if($side_deal['Deal']['deal_status_id'] == ConstDealStatus::Open): ?>											
												<span><?php echo $html->image('deal_open.png',array('style'=>'')); ?></span>
												<?php endif; ?>
												<span style="color: #ffe7eb;text-shadow: black 0.1em 0.1em 0.2em;text-decoration: none;">
													<?php echo $html->cInt($side_deal['Deal']['deal_user_count']);?>
													<?php echo __l('Bought');?>
												</span>												
											</div>								
										</div>
									</div>											
								</div>
								<br style="line-height: 10px;"/>
								<?php 
								if($i!=(count($side_deals)-1)):
								?>
								<div class="sidesep">&nbsp;</div>
								<div style="height: 5px;">&nbsp;</div>
								<?php 
								endif;
								?>								
		                  <?php
		                  	$i++;
							endforeach;
		                 ?>					
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
			</div>	
			<?php  endif;	?>	
			<!-- BUSINESS -->
			<div style="height:10px;">&nbsp;</div>
			<div id="business">
				<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr height="100">
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<h3><?php echo sprintf(__l('Get Your Business on %s!'), Configure::read('site.name')); ?></h3>						
							<div class="new-img-competitors"></div>
			                	<p class="mdnormal" ><?php echo __l('Learn More for the basics.'); ?> <?php echo sprintf(__l('about how %s can help bring tonnes of customers to your door'), Configure::read('site.name'));?></p>
			               		<?php echo $html->link(__l('Learn More'), array('controller' => 'pages', 'action' => 'view','company', 'admin' => false), array('title' => __l('Learn More'),'class'=>'learn'));?>
			               	</div>
			               	<div style="height: 10px;"></div>						
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- CONTACT US -->
			<div style="height:10px;">&nbsp;</div>
			<div id="contactus">
				<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr height="100">
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<h3><?php echo sprintf(__l('%s - Boite aux questions!'), Configure::read('site.name')); ?></h3>						
							<div class="new-img-contactus"></div>
			                	<p class="mdnormal" ><?php echo __l('Learn More for the basics.'); ?> <?php echo sprintf(__l('about how %s can help bring tonnes of customers to your door'), Configure::read('site.name'));?></p>			               		
			               		<?php echo $html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact us'),'class'=>'learn'));?>
			               	</div>
			               	<div style="height: 10px;"></div>						
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- CONTACT US -->
			<div style="height:10px;">&nbsp;</div>
			<div id="contactus">
				<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr>
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<div style="height: 5px;"></div>
							<?php echo $html->link(__l('Buy a').' '.Configure::read('site.name').' '.__l('Gift Card'), array('controller' => 'gift_users', 'action' => 'add'), array('class' => 'buy', 'title' => __l('Buy a').' '.Configure::read('site.name').' '.__l('Gift Card'))); ?>
							<div style="height: 5px;"></div>						
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
			</div>
			<!-- FACEBOOK FAN PAGE -->
			<div style="height:10px;">&nbsp;</div>
			<div id="facebook">
				<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr height="20">
						<td id="md_deal_price_top_left" width="17">&nbsp;</td>
						<td id="md_deal_price_top" >&nbsp;</td>
						<td id="md_deal_price_top_right" width="18">&nbsp;</td>
					</tr>
					<tr>
						<td id="md_deal_price_left" width="17">&nbsp;</td>
						<td id="md_deal_price_texture" >
							<?php
							$facebook_like_box = Configure::read('facebook.like_box');
							if(!empty($facebook_like_box)):?>
								<div class="facebook-block clearfix">
									<?php echo $facebook_like_box;?>
								</div>
							<?php
							endif;
							?>
							 <?php
								$facebook_feeds_code = Configure::read('facebook.feeds_code');
								if(!empty($facebook_feeds_code)):?>
									<div class="facebook-block clearfix">
										<?php echo $facebook_feeds_code;?>
									</div>
								<?php
								endif;
							 ?>						
						</td>
						<td id="md_deal_price_right" width="18">&nbsp;</td>
					</tr>
					<tr height="20">
						<td id="md_deal_price_bottom_left" width="17">&nbsp;</td>
						<td id="md_deal_price_bottom">&nbsp;</td>
						<td id="md_deal_price_bottom_right" width="18">&nbsp;</td>
					</tr>
				</table>
			</div>			
			
      	</div>      	
      </div>
      
      <div class="side2">
      	<?php if ($count == 1 || !empty($from_page)) { ?>         
        <!-- <div class="blue-bg1 clearfix">
          <div class="tweet-tl">
            <div class="tweet-tr">
              <div class="tweet-tm">
                <h3>Tweets Around</h3>
              </div>
            </div>
          </div>
          <div class="side1-cl">
            <div class="side1-cr">
              <div class="block1-inner blue-bg-inner clearfix">
              <?php	if(Configure::read('twitter.is_twitter_feed_enabled')):
    				echo strtr(Configure::read('twitter.tweets_around_city'),array(
    					'##CITY_NAME##' => ucwords($city_name),
    				));
    			endif;
                ?>
              </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
          </div>
        </div> -->
        <?php } ?>
      </div>
            
    </div>
   <div id="fb-root"></div>
	<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>