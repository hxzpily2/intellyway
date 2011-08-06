<?php
$javascript->link('libs/divs', false);
?>

<?php /* SVN: $Id: view.ctp 44785 2011-02-19 10:54:51Z aravindan_111act10 $ */ ?>
<?php if($this->params['action'] !='index'):
	if($html->isAllowed($auth->user('user_type_id')) and   $deal['Deal']['deal_status_id'] != ConstDealStatus::Open && $deal['Deal']['deal_status_id'] != ConstDealStatus::Tipped && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval  && $deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming ):?>
		<div id="missed_deal_announcement" class="announcement">
			  <p id="txt_missed_groupon">
				<?php echo __l('Oh no... You\'re too late for this ').' '.Configure::read('site.name').'!';?>
			  </p>
			  <div class="announcement_inner clearfix">
				<div class="left">
				  <p>
					<?php echo __l('Sign up for our daily email so you never miss another').' '.Configure::read('site.name').'!';?>
				  </p>
				</div>
				<div class="right">
				  <?php echo $this->element('../subscriptions/add', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
				</div>
			  </div>
	 </div>
	<?php endif; ?>
<?php endif; ?>
    <div class="deal-view-inner-block clearfix">
      <div class="main-shad">&nbsp;</div>
      <div id="md_deal_global_infos">
      	<div id="md_deal_infos">
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
						<h2 class="title">
		        			<span class ="today-deal">
		        				<!--
		        				<?php if($this->params['action'] =='index'):?>
		        					<?php	echo __l("Today's Deal").': ';?>
		        				<?php endif; ?>
		        				-->
		        			</span>
		            		<?php
		            			echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));
		            		?>
			           	</h2>
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
      	</div>
      	<div id="md_right_block">
      		<div id="md_price_economie_block">
      			
      		</div>      		
      		<div id="md_price_block">
      			<div id="md_price_value">
      				<p class="price"><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price']));?></p>
      				<p class="oldprice">
      					<?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price']));?>
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
								<span class="no-available" title="<?php echo __l('Upcoming');?>"><?php echo __l('Upcoming');?></span>
							<?php
								else:
							?>
								<span class="no-available" title="<?php echo __l('No Longer Available');?>"><?php echo __l('No Longer Available');?></span>
							<?php
							endif;
						endif;
	                ?>
      			</div>
      		</div>
      		<?php echo $this->element("counter",array("ID"=>$deal['Deal']['id']));?>
      		<table id="md_counter_block" cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr height="20">
					<td id="md_deal_price_top_left" width="17">&nbsp;</td>
			   	    <td id="md_deal_price_top" >&nbsp;</td>
					<td id="md_deal_price_top_right" width="18">&nbsp;</td>
				</tr>
				<tr height="300">
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
      	</div>
      </div>
      <div class="side1">
        <div class="block1 clearfix">
          <div class="side1-tl">
            <div class="side1-tr">
              <div class="side1-tm"> </div>
            </div>
          </div>
          <div class="side1-cl">
            <div class="side1-cr">
              <div class="block1-inner">
                <h2 class="title">
        			<span class ="today-deal">
        				<?php if($this->params['action'] =='index'):?>
        					<?php	echo __l("Today's Deal").': ';?>
        				<?php endif; ?>
        			</span>
            		<?php
            			echo $html->link($deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$deal['Deal']['name'])));
            		?>
	           	</h2>
                <!--<p class="title-info">offer holistic treatments with a blend of unique therapies inspired by Ayurvedic and yogic traditions.</p>-->
   				<?php if($this->params['action'] !='index'):?>
					<div class="gallery-block">
						<div id='js-gallery'>
								<?php foreach($deal['Attachment'] as $attachment){?>
									<a><?php echo $html->showImage('Deal', $attachment, array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?></a>
								<?php } ?>
						</div>
					</div>
				<?php else:?>
					<div>
						<div>
							<ul>
								<li><?php echo $html->showImage('Deal', $deal['Attachment'][0], array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($deal['Deal']['name'], false)), 'title' => $html->cText($deal['Deal']['name'], false)));?></li>
							</ul>
						</div>
					</div>
				<?php endif;?>
                <div class="buy-block clearfix">
                  <div class="deal-block clearfix">
                       <dl class="deal-value clearfix">
    					 <dt><?php echo __l('Value');?></dt>
    					 <dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['original_price']));?></dd>
    				  </dl>
    				  <dl class="deal-discount clearfix">
    					<dt><?php echo __l('Discount');?></dt>
    					<dd><?php echo $html->cFloat($deal['Deal']['discount_percentage']) . "%"; ?></dd>
    				  </dl>
    				  <dl class="deal-save clearfix">
    					<dt><?php echo __l('You Save');?></dt>
    					<dd><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['savings'])); ?></dd>
    	       		  </dl>
                 </div>
                  <div class="tag clearfix">
                      <p class="price"><?php echo $html->siteCurrencyFormat($html->cCurrency($deal['Deal']['discounted_price']));?></p>
                      	<?php //$deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming
					if($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval):
						if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped):
							 echo $html->link(__l('Buy Now'), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id']), array('title' => __l('Buy Now'),'class' =>'button'));
						elseif($html->isAllowed($auth->user('user_type_id')) && $deal['Deal']['deal_status_id'] == ConstDealStatus::Upcoming):
						?>
							<span class="no-available" title="<?php echo __l('Upcoming');?>"><?php echo __l('Upcoming');?></span>
						<?php
							else:
						?>
							<span class="no-available" title="<?php echo __l('No Longer Available');?>"><?php echo __l('No Longer Available');?></span>
						<?php
						endif;
					endif;
                ?>
                   </div>
                </div>
                <div class="clearfix">
                  <div class="section1">
                    <div class="price-block -block">
                    
                     <?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped || $deal['Deal']['deal_status_id'] == ConstDealStatus::Closed): ?>
                      <div class="bought-block clearfix">
                            <?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped || $deal['Deal']['deal_status_id'] == ConstDealStatus::Closed): ?>
                            <p class="bought-amount"><?php echo $html->cInt($deal['Deal']['deal_user_count']);?> <?php echo __l('offers sold so far');?></p>
                            <div class="bought-info">
                            	<?php if($deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped): ?>
                                <p class="deal-on"><?php echo __l('The deal is on!');?></p>
                              	 <p class="quick-info"> <?php echo __l('Get in quick or miss out!');?> </p>
                                <?php endif; ?>
                               <p class="tipped-info"><?php echo sprintf(__l('Tipped at %s with %s bought'),$html->cDateTime($deal['Deal']['deal_tipped_time']),$html->cInt($deal['Deal']['min_limit']));?></p>
                             </div>
                       <?php else: ?>
                        <div class="progress-tl">
                          <div class="progress-tr">
                            <div class="progress-tm"> </div>
                          </div>
                        </div>
                        <div class="progress-inner clearfix">
                          <h3><?php echo $html->cInt($deal['Deal']['deal_user_count']);?> <?php echo __l('Bought');?></h3>
                            <?php
                                $pixels = round(($deal['Deal']['deal_user_count']/$deal['Deal']['min_limit']) * 100);
                            ?>
                            <p class="progress-bar round-5"><span class="arrow" style="left:<?php echo $pixels; ?>%"><?php echo $pixels; ?></span><span class="progress-status round-5" style="width:<?php echo $pixels; ?>%" title="<?php echo $pixels; ?>%">&nbsp;</span></p>
                            <p class="progress-value clearfix"><span class="progress-from">0</span><span class="progress-to"><?php echo $html->cInt($deal['Deal']['min_limit']); ?></span></p>
                            <p class="progress-desc"><?php echo sprintf(__l('%s more needed to get the deal'),($deal['Deal']['min_limit'] - $deal['Deal']['deal_user_count'])) ?></p>
                         </div>
                        <div class="progress-bl">
                          <div class="progress-br">
                            <div class="progress-bm"> </div>
                          </div>
                        </div>
                      <?php endif; ?>
                      </div>
                  <?php endif; ?>
               <?php if($deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft): ?>
               <div class="progress-block clearfix">
                        <div class="progress-tl">
                          <div class="progress-tr">
                            <div class="progress-tm"> </div>
                          </div>
                        </div>
                        <div class="progress-inner clearfix">
                    <?php if(($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped)): 
							if(empty($deal['Deal']['is_anytime_deal'])){
					?>
                        <dl class="progress-list">
                            <dt><?php echo __l('Time left to buy');?></dt>
                            <dd>
                                <div class="js-deal-end-countdown">&nbsp;</div>
                                <span class="js-time hide"><?php
                                    echo $end_time = intval(strtotime($deal['Deal']['end_date'].' GMT') - time());
                                ?></span>
                            </dd>
                         </dl>
                   <?php
				   			}
							else{
					?>
                    	 <dl class="progress-list">
                            <dt><?php echo __l('Time left to buy');?></dt>
                            <dd>
                                <span class="unlimited"><?php echo __l("Unlimited"); ?></span>
                            </dd>
                         </dl>
                    <?php 
							}
                        $per = (strtotime($deal['Deal']['end_date']) - strtotime($deal['Deal']['start_date']))  / 10;
                        $next =  round((strtotime(date('Y-m-d H:i:s')) - strtotime($deal['Deal']['start_date'])) / $per);
                        if($next <= 0){
                            $next = 1;
                        }
                        if($next >= 10){
                            $next = 10;
                        }
                    ?>
                    <div class="pg-img"><?php echo $html->image("clock-img.png", array('alt'=> __l('[Image: Progress]'), 'title' => __l('Progress'))); ?></div>
                    <?php elseif($deal['Deal']['deal_status_id'] == ConstDealStatus::Closed || $deal['Deal']['deal_status_id'] == ConstDealStatus::Canceled || $deal['Deal']['deal_status_id'] == ConstDealStatus::Expired || $deal['Deal']['deal_status_id'] == ConstDealStatus::PaidToCompany): ?>
                        <dl class="progress-list progress-list1">
                            <dt><?php echo __l('This deal ended at:');?></dt>
                            <dd><?php echo $html->cDateTime($deal['Deal']['end_date'])?></dd>
                         </dl>
                    <?php endif; ?>
                  </div>
                        <div class="progress-bl">
                          <div class="progress-br">
                            <div class="progress-bm"> </div>
                          </div>
                        </div>
                      </div>
			   <?php endif; ?>

                  <?php  if(($deal['Deal']['deal_status_id'] == ConstDealStatus::Open || $deal['Deal']['deal_status_id'] == ConstDealStatus::Tipped) && $html->isAllowed($auth->user('user_type_id'))):?>
                    <div class="clearfix">
                      <div class="buy-it-block">
                        <?php echo $html->link(__l('Buy it for a friend!'), array('controller'=>'deals','action'=>'buy',$deal['Deal']['id'],'type' => 'gift'), array('title' => __l('Buy it for a friend'),'class' =>'buy-it'));?>
    				  </div>
    				  </div>
                    <?php endif; ?>
                      <div class="share-block1 share-block clearfix">
                       <span><?php echo __l('Share This Deal: '); ?></span>
                        <ul class="share-list">
                            <?php
            					if(Configure::read('site.city_url') == 'prefix'):
            						$bityurl = $deal['Deal']['bitly_short_url_prefix'];
            					else:
            						$bityurl = $deal['Deal']['bitly_short_url_subdomain'];
            					endif;
            				?>
                            <li class="quick"><?php echo $html->link(__l('Quick! Email a friend!'), 'mailto:?body='.__l('Check out the great deal on ').Configure::read('site.name').' - '.Router::url('/', true).'deal/'.$deal['Deal']['slug'].'&amp;subject='.__l('I think you should get ').Configure::read('site.name').__l(': ').$deal['Deal']['discount_percentage'].__l('% off at ').$deal['Company']['name'], array('target' => 'blank', 'title' => __l('Send a mail to friend about this deal'), 'class' => 'quick'));?></li>
							<li class="twitter-frame"><a href="http://twitter.com/share?url=<?php echo $bityurl;?>&amp;text=<?php echo urlencode_rfc3986($deal['Deal']['name']);?>&amp;lang=en&amp;via=<?php echo Configure::read('site.name'); ?>" data-count="none" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
                            <li class="share-list"><fb:like href="<?php echo Router::url('/', true).'deal/'.$deal['Deal']['slug'];?>" layout="button_count" font="tahoma"></fb:like></li>
                        </ul>
                      </div>
                      
                    </div>
                  </div>
                  <div class="section2">
                    <div class="fine-print-block">
                        <h3><?php echo __l('The Fine Print');?></h3>
                        <?php if(!empty($deal['Deal']['coupon_expiry_date'])){
		                 		 echo __l('Expires '); 
		                         echo  $html->cDateTime($deal['Deal']['coupon_expiry_date']);
							  }	  
							  echo ' '.$html->cHtml($deal['Deal']['coupon_condition']);
						?>
                        <?php echo $html->link(__l('Read the Deal FAQ'), array('controller' => 'pages', 'action' => 'view','faq', 'admin' => false), array('target'=>'_blank', 'title' => __l('Read the deal FAQ')));?> <?php echo __l(' for the basics.'); ?>
                    </div>
                    <div class="highlight-block">
                      <h3><?php echo __l('Highlights');?></h3>
                      <?php echo $html->cHtml($deal['Deal']['coupon_highlights']);?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
          </div>
        </div>
        <div class="block2 clearfix">
          <div class="side1-tl">
            <div class="block2-tr">
              <div class="side1-tm">
                <div class="block2-top"></div>
              </div>
            </div>
          </div>
          <div class="side1-cl">
            <div class="block2-cr">
              <div class="block2-inner clearfix">
                <div class="block2-l">
                   <h3><?php echo __l('Description');?></h3>
                    <?php echo $html->cHtml($deal['Deal']['description']);?>
                  <div class="review-block clearfix">
                    <?php if(!empty($deal['Deal']['review'])){?>
        				<h3><?php echo __l('Reviews');?></h3>
        				<div class="big-text"><?php echo $html->cHtml($deal['Deal']['review']);?></div>
			      <?php }?>
                 <?php if($deal['Deal']['deal_status_id'] != ConstDealStatus::Upcoming && $deal['Deal']['deal_status_id'] != ConstDealStatus::Draft && $deal['Deal']['deal_status_id'] != ConstDealStatus::PendingApproval): ?>
	           	 <div class="join-discussion-block">
			     	<?php if(!empty($deal['Topic'][0]['topic_discussion_count'])):?>
					<div class="deal-area clearfix">
						<div class="deal-l">
                        	<?php echo $html->getUserAvatarLink($deal['Topic'][0]['LastRepliedUser'], 'small_thumb');?>
						</div>
						<p class="deal-r">
							<?php echo $html->truncate($deal['Topic'][0]['TopicDiscussion'][0]['comment']); ?>
							<?php echo $html->link(__l(' more'), array('controller' => 'topic_discussions', 'action' => 'index', $deal['Topic'][0]['id'])); ?>
						</p>
					</div>
					<div class="discussion-block">
					
                        <div class="clearfix">
                        	<p class="first-comment">
    							<?php echo $html->link(__l('Join the discussion!'), array('controller' => 'topic_discussions', 'action' => 'index', $deal['Topic'][0]['id']),array('title'=>__l('Join the discussion!'),'class'=>'joing-link')); ?>
    						</p>
						</div>
						<p class="comment-info">
							<?php echo  $html->cInt($deal['Topic'][0]['topic_discussion_count']).' Comments';?>
                        </p>
                	</div>
				<?php else: ?>
				 <div class="clearfix">
					<p class="first-comment">
						<?php echo $html->link(__l('Be the first to comment!'), array('controller' => 'topic_discussions', 'action' => 'index', $deal['Topic'][0]['id']),array('title'=>__l('Be the first to comment!'),'class'=>'joing-link')); ?>
					</p>
					</div>
				<?php endif; ?>
				
        		</div>
    	   <?php endif; ?>
                       </div>
                  <?php if(!empty($deal['Deal']['comment'])) {?>
						<h3><?php echo Configure::read('site.name').' '.__l('says');?></h3>
                       <?php echo $html->cHtml($deal['Deal']['comment']);?>
                  <?php } ?>
               
                 <ul class="share-link clearfix">
                    <?php
            							if(!empty($city_slug)):
            								$tmpURL= $html->getCityTwitterFacebookURL($city_slug);
            							endif;
            		?>
                    <li><a href="<?php echo !empty($tmpURL['City']['twitter_url']) ? $tmpURL['City']['twitter_url'] : Configure::read('twitter.site_twitter_url'); ?>" title="<?php echo __l('Follow Us in Twitter'); ?>" target="_blank" class="twitter1"><?php echo __l('follow @');?><?php echo Configure::read('site.name');?><?php echo __l(' on Tweet'); ?></a></li>
                    <li><a href="<?php echo !empty($tmpURL['City']['facebook_url']) ? $tmpURL['City']['facebook_url'] : Configure::read('facebook.site_facebook_url'); ?>" title="<?php echo __l('See Our Profile in Facebook'); ?>" target="_blank" class="facebook1"><?php echo __l('follow @');?><?php echo Configure::read('site.name');?><?php echo __l(' on Facebook it'); ?></a></li>
                </ul>
                  
                </div>
                <div class="block2-r">
                     <h3><?php echo __l('Company Info:');?></h3>
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
                    <div class="map-block">
            			<?php $map_zoom_level = !empty($deal['Company']['map_zoom_level']) ? $deal['Company']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');?>
            			<a href="http://maps.google.com/maps?q=<?php echo $html->url(array('controller' => 'companies', 'action' => 'view',$deal['Company']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level?>" title="<?php echo $deal['Company']['name'] ?>" target="_blank">
            			<?php
            			$company = $deal['Company'];
            			$company['CompanyAddress']= $deal['Company']['CompanyAddress'];
            			if(Configure::read('GoogleMap.embedd_map') == 'Static'):
            				echo $html->image($html->formGooglemap($company,'192x100'));
            			else:
            				echo $html->formGooglemap($company,'192x100');
            			endif;
            			?></a>
            			<?php if(Configure::read('GoogleMap.embedd_map') != 'Static'):?>
            				<small>
            					<a href="http://maps.google.com/maps?q=<?php echo $html->url(array('controller' => 'companies', 'action' => 'view',$deal['Company']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level.'&amp;source=embed' ?>" title="<?php echo $deal['Company']['name'] ?>" target="_blank" style="color:#0000FF;text-align:left"><?php echo __l('View Larger Map');?></a>
            				</small>
            			<?php endif;?>
        			</div>
					<?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="block2-br">
              <div class="side1-bm">
                <div class="block2-bottom"></div>
              </div>
            </div>
          </div>
        </div>
          <?php if (($auth->user('user_type_id') == ConstUserTypes::Company && $deal['Company']['user_id'] == $auth->user('id')) || $auth->user('user_type_id') == ConstUserTypes::Admin):?>
            <div class="js-tabs">
    			<ul class="clearfix">
    				<li><?php echo $html->link(__l('Deal Coupons'), '#tabs-'.$deal['Deal']['id']);?></li>
    			</ul>
    			<div id="tabs-<?php echo $deal['Deal']['id']; ?>" ><?php echo $this->element('deal_users-index', array('deal_id' => $deal['Deal']['id'], 'cache' => array('time' => Configure::read('site.element_cache')))); ?></div>
    		</div>
	<?php endif; ?>
      </div>
      <div class="side2">
      	<?php if ($count == 1 || !empty($from_page)) { ?>
        <div class="blue-bg deal-blue-bg clearfix">
          <div class="deal-tl">
            <div class="deal-tr">
              <div class="deal-tm">
                <h3>
                 <?php echo __l('Give the Gift of').' '.Configure::read('site.name');?>
                </h3>
              </div>
            </div>
          </div>
          <div class="side1-cl">
            <div class="side1-cr">
              <div class="block1-inner blue-inner clearfix">
                <!--<p>
                    <span>$50</span><?//php echo __l('available information is here');?>
                </p>-->
				<?php echo $html->link(__l('Buy a').' '.Configure::read('site.name').' '.__l('Gift Card'), array('controller' => 'gift_users', 'action' => 'add'), array('class' => 'buy', 'title' => __l('Buy a').' '.Configure::read('site.name').' '.__l('Gift Card'))); ?>
              </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
          </div>
        </div>
       
         <?php if(Configure::read('deal.is_side_deal_enabled') && !empty($side_deals)): ?>
          <div class="blue-bg top clearfix">
            <div class="deal-tl">
            <div class="deal-tr">
              <div class="deal-tm">
                <h3>
                 <?php echo __l('Today Side Deals');?>
                </h3>
              </div>
            </div>
          </div>
          <div class="side-deal-cl">
            <div class="side-deal-cr">
              <div class="block1-inner blue-bg-inner clearfix">
                <div class="side-deal">
                <ol class="side-deal-list">
				<?php
                	foreach($side_deals as $side_deal):
						?>
						<li>
					<h4><?php echo $html->link($side_deal['Deal']['name'], array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$side_deal['Deal']['name'])));?></h4>
                    <div class="clearfix">
                    <div class="deal1-img">
                     	  <?php echo $html->link($html->showImage('Deal', $side_deal['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($side_deal['Deal']['name'], false)), 'title' => $html->cText($side_deal['Deal']['name'], false))), array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('title' =>sprintf(__l('%s'),$side_deal['Deal']['name'])), null, false);?>
                    </div>
                    <div class="deal-button">
                      <div class="deal-price clearfix">
                        <div class="deal-price-l">
                          <div class="deal-price-r clearfix">
                           <div class="deal-currency"><?php echo $html->siteCurrencyFormat($html->cCurrency($side_deal['Deal']['discounted_price']));?></div>
                            <div class="deal-value-info">
                         		 <span>
        					 <?php echo $html->siteCurrencyFormat($html->cCurrency($side_deal['Deal']['original_price']));?>
                                 <?php echo __l('Value');?>
                                </span>
                            </div>
                          </div>
                        </div>
                      </div>
                         <?php echo $html->link(__l('View it'), array('controller' => 'deals', 'action' => 'view', $side_deal['Deal']['slug']),array('title' =>'View it'), null, false);?>
                      </div>
                  </div>
                  </li>
                  <?php
					endforeach;
                 ?>
                 </ol>
                </div>
              </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
          </div>
               </div>
              <?php endif; ?>
          <div class="blue-bg clearfix">
          <div class="business-tl">
            <div class="business-tr">
              <div class="business-tm">
              	<h3><?php echo sprintf(__l('Get Your Business on %s!'), Configure::read('site.name')); ?></h3>
              </div>
            </div>
          </div>
          <div class="side1-cl">
            <div class="side1-cr">
              <div class="block1-inner blue-bg-inner clearfix">
                <div class="new-img"></div>
                <p class="normal" ><?php echo __l('Learn More for the basics.'); ?> <?php echo sprintf(__l('about how %s can help bring tonnes of customers to your door'), Configure::read('site.name'));?></p>
               <?php echo $html->link(__l('Learn More'), array('controller' => 'pages', 'action' => 'view','company', 'admin' => false), array('title' => __l('Learn More'),'class'=>'learn'));?>
               </div>
            </div>
          </div>
          <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
          </div>
        </div>
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
        <div class="blue-bg1 clearfix">
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
        </div>
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