<?php
/* SVN FILE: $Id: default.ctp 44816 2011-02-19 12:02:30Z aravindan_111act10 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $html->cText($title_for_layout, false);?></title>
	<?php
		echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
	?>
	<link href="<?php echo Router::url('/', true) . $this->params['named']['city'] .'.rss';?>" type="application/rss+xml" rel="alternate" title="RSS Feeds" target="_blank" />
	<?php
		require_once('_head.inc.ctp');
		echo $asset->scripts_for_layout();
	?>
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
	<?php if(!empty($meta_for_layout['deal_name'])):?>
		<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
		<meta property='og:title' content='<?php echo $meta_for_layout['deal_name'];?>'/>
	<?php endif;?>
	<?php if(!empty($meta_for_layout['deal_image'])):?>
		<meta property="og:image" content="<?php echo $meta_for_layout['deal_image'];?>"/>
	<?php else:?>
		<meta property="og:image" content="<?php echo Router::url(array(
				'controller' => 'img',
				'action' => 'blue-theme',
				'logo-email.png',
				'admin' => false
			) , true);?>"/>
	<?php endif;?>
</head>
<?php	
	
	if (!empty($city_attachment['id']) && empty($this->params['requested']) && $this->params['controller'] != 'images' && empty($_SESSION['city_attachment'])):
		$_SESSION['city_attachment'] =  $html->url($html->getImageUrl('City', $city_attachment, array('dimension' => 'original')));
	endif; 		
?>
<body style="<?php echo !empty($_SESSION['city_attachment']) ? 'background:url('.$_SESSION['city_attachment'].') repeat fixed left top':''; ?>">
	<div class="js-morecities1 top-slider1  hide">
	<div class="cities-index-block">
    <?php echo $this->element('cities-index', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
    </div>
    </div>
	<div class="top-slider1 js-show-subscription hide">
	<?php if($html->isAllowed($auth->user('user_type_id')) && $this->params['controller'] != 'subscriptions'): ?>
          <?php echo $this->element('../subscriptions/add', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
	<?php endif; ?>
	<ul class="header-nav">
		<?php
			$cityArray = array();
			if(!empty($city_slug)):
				$tmpURL= $html->getCityTwitterFacebookURL($city_slug);
				$cityArray = array('city'=>$city_slug);
			endif;
		?>
		<li class="rss"><?php echo $html->link(__l('RSS'), array_merge(array('controller'=>'deals', 'action'=>'index', 'ext'=>'rss'), $cityArray), array('target' => '_blank','title'=>__l('RSS Feed'))); ?></li>
		<li class="twitter"><a href="<?php echo !empty($tmpURL['City']['twitter_url']) ? $tmpURL['City']['twitter_url'] : Configure::read('twitter.site_twitter_url'); ?>" title="<?php echo __l('Follow Us in Twitter'); ?>" target="_blank"><?php echo __l('Twitter'); ?></a></li>
		<li class="facebook"><a href="<?php echo !empty($tmpURL['City']['facebook_url']) ? $tmpURL['City']['facebook_url'] : Configure::read('facebook.site_facebook_url'); ?>" title="<?php echo __l('See Our Profile in Facebook'); ?>" target="_blank"><?php echo __l('Facebook'); ?></a></li>
	</ul>
	<?php
		if($auth->sessionValid()  and  $auth->user('user_type_id') == ConstUserTypes::Company):
				$company = $html->getCompany($auth->user('id'));
		endif;
	?>
	</div>
	<!-- MENU -->
	<div class="menu-content">
		<div class="global-block">
          <ul class="global-links-r">
               <li class="down-arrow"><?php echo $html->link(__l('Visit More Cities'), '#', array('title' => __l('Visit More Cities'), 'class' => "js-toggle-show {'container':'js-morecities1'}")); ?></li>
				<?php if($html->isAllowed($auth->user('user_type_id')) && $this->params['controller'] != 'subscriptions'): ?>
                    <li class="down-arrow"><?php echo $html->link(sprintf(__l('Get Daily').' %s'.' '.__l('Alerts'), Configure::read('site.name')), '#', array('title' => sprintf(__l('get daily').' %s'.__l('Alerts'), Configure::read('site.name')), 'class' => "js-toggle-show {'container':'js-show-subscription'}")); ?></li>
                <?php endif; ?>
          	  <?php //if($html->isAllowed($auth->user('user_type_id')) && Configure::read('user.is_referral_system_enabled')): ?>
                      <li><?php echo $html->link(__l('Refer Friends, Get').' '.$html->siteCurrencyFormat($html->cCurrency(Configure::read('user.referral_amount'), false)), array('controller' => 'pages', 'action' => 'refer_a_friend'), array('title' => __l('Refer Friends and Get').' '. $html->siteCurrencyFormat($html->cCurrency(Configure::read('user.referral_amount')))));?></li>
              <?php //endif; ?>
                <li><?php echo $html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact us')));?></li>
          </ul>
        </div>
		<table width="1166" height="100%" cellpadding="0" cellspacing="0" border="0">
			<tr style="line-height:12px;">
				<td width="123">&nbsp;</td>
				<td width="920"><div class="menu-top-bg">&nbsp;</div></td>
				<td width="123">&nbsp;</td>
			</tr>
			<tr>
				<td width="123" align="right"><div class="menu-left-bg">&nbsp;</div></td>
				<td width="920"><div class="menu-content-bg">&nbsp;</div></td>
				<td width="123"><div class="menu-right-bg">&nbsp;</div></td>
			</tr>
			<tr>
				<td width="123"></td>
				<td width="920"><div class="menu-bottom-bg">&nbsp;</div></td>
				<td width="123"></td>
			</tr>
		</table>
	</div>
	<div id="<?php echo $html->getUniquePageId();?>" class="content">
   <div id="header">
    <div id="header-content">
   
     <div class="side1-cl">
        <div class="side1-cr">
            <div class="block1-inner">
      <div class="clearfix">
        <h1>
                <?php echo $html->link(Configure::read('site.name'), array('controller' => 'deals', 'action' => 'index', 'admin' => false), array('title' => Configure::read('site.name'))); ?>
			</h1>
            <p class="hidden-info"><?php echo __l('Collective Buying Power');?></p>
         <?php if($auth->sessionValid() && $auth->user('user_type_id') == ConstUserTypes::Admin): ?>
            <div class="admin-bar">
                <h3><?php echo __l('You are logged in as '); ?><?php echo $html->link(__l('Admin'), array('controller' => 'users' , 'action' => 'stats' , 'admin' => true), array('title' => __l('Admin'))); ?></h3>
                <div><?php echo $html->link(__l('Logout'), array('controller' => 'users' , 'action' => 'logout', 'admin' => true), array('title' => __l('Logout'))); ?></div>
            </div>
     <?php endif; ?>
        <div class="header-r">
          <div class="clearfix">
            
          </div>
          <div class="city-block clearfix">
           	<?php if($html->isAllowed($auth->user('user_type_id')) && $this->params['controller'] != 'subscriptions'): ?>
          <?php echo $this->element('../subscriptions/add', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
        <?php endif; ?>
            <div class="city-desc-block clearfix">
              <?php if(!empty($city_name)): ?>
                        <h2><?php echo __l('Daily Deals on the Best in'); ?>
                     
                        	<?php
								if (Cache::read('site.city_url', 'long') == 'prefix') {
									echo $html->link($html->cText($city_name), array('controller' => 'deals', 'action' => 'index', 'city' => $city_slug), array('title' => $html->cText($city_name, false),'class'=>'city-name' ,'escape' => false));
								} elseif (Cache::read('site.city_url', 'long') == 'subdomain') {
									$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));
									$sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
									if (strlen($subdomain) > 0) {
							?>
										<a href="http://<?php echo $city_slug . $sitedomain; ?>" title="<?php echo $html->cText($city_name, false); ?>"><?php echo $html->cText($city_name); ?></a>
							<?php
									} else {
										echo $html->link($html->cText($city_name), array('controller' => 'deals', 'action' => 'index', 'city' => $city_slug), array('title' => $html->cText($city_name, false), 'escape' => false));
									}
								}
							?>

                      </h2>
      	
							<div class="js-morecities top-slider  hide"> <?php echo $this->element('cities-index', array('cache' => array('time' => Configure::read('site.element_cache'))));?></div>
						

                <?php endif;?>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix">
      	<?php echo $this->element('lanaguge-change-block', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
		<?php $total_array = $html->total_saved(); ?>
		  <dl class="total-list clearfix">
			<dt><?php echo __l('Total Saved: '); ?></dt>
			<dd><span><?php echo $html->siteCurrencyFormat($html->cCurrency($total_array['total_saved'])); ?></span></dd>
			<dt><?php echo __l('Total Bought: '); ?></dt>
			<dd><?php echo $html->cInt($total_array['total_bought']); ?></dd>
			 <?php if($auth->sessionValid() && $html->isWalletEnabled('is_enable_for_add_to_wallet')): ?>
				<dt><?php echo __l('Balance: '); ?></dt>
				<?php
					if (empty($user_available_balance)):
						$user_available_balance = 0;
					endif;
				?>
				<dd><span><?php echo $html->siteCurrencyFormat($html->cCurrency($user_available_balance)); ?></span></dd>
            <?php endif; ?>
          </dl>
            <?php if($auth->sessionValid() && $html->isWalletEnabled('is_enable_for_add_to_wallet')): ?>
            <div class="add-amount">
            	<?php if ((Configure::read('company.is_user_can_withdraw_amount') && $auth->user('user_type_id') == ConstUserTypes::Company) || (Configure::read('user.is_user_can_with_draw_amount') && $auth->user('user_type_id') == ConstUserTypes::User)) { ?>
                	<?php echo $html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request'),'class'=>'width-draw'));?>
				<?php } ?>
				<?php if($html->isAllowed($auth->user('user_type_id'))): ?>
				<?php echo $html->link(__l('Add amount to wallet'), array('controller' => 'users', 'action' => 'add_to_wallet'), array('class' => 'add add-wallet', 'title' => __l('Add amount to wallet'))); ?>
                <?php endif; ?>
            </div>
             <?php endif; ?>
	
        
      </div>
      <div class="menu-block clearfix">
        <ul class="menu clearfix">
        	<?php if($html->isAllowed($auth->user('user_type_id'))): ?>
                <li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'index' && !isset($this->params['named']['type']) && !isset($this->params['named']['company'])) { echo 'class="active"'; } ?>><?php echo $html->link(__l('Today\'s Deals'), array('controller' => 'deals', 'action' => 'index', 'admin' => false), array('title' => __l('Today\'s Deals')));?></li>
                <li <?php if($this->params['controller'] == 'deals' && (isset($this->params['named']['type']) && $this->params['named']['type'] == 'recent')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Recent Deals'), array('controller' => 'deals', 'action' => 'index', 'admin' => false,'type' => 'recent'), array('title' => __l('Recent Deals')));?></li>
               <?php endif; ?>
				<li <?php if($this->params['controller'] == 'topics' or $this->params['controller'] == 'topic_discussions' ) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Discussion'), array('controller' => 'topics', 'action' => 'index', 'admin' => false), array('title' => __l('Discussion')));?></li>

				<li <?php if($this->params['controller'] == 'pages' && $this->params['action'] == 'view'  && $this->params['pass'][0] == 'learn') { echo 'class="active"'; } ?>><?php echo $html->link(sprintf(__l('How')." ".'%s'." " .__l('Works'), Configure::read('site.name')), array('controller' => 'pages', 'action' => 'view', 'learn', 'admin' => false), array('title' => sprintf(__l('How')." ".'%s'." ".__l(' Works'), Configure::read('site.name'))));?></li>

				<?php if(!$auth->sessionValid()):
				$url = strstr($this->params['url']['url'],"/company/user/register");?>
					<li <?php if((!empty($url)) || ($this->params['controller'] == 'pages' && $this->params['action'] == 'view' &&  $this->params['pass'][0] == 'company')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Business'), array('controller' => 'pages', 'action' => 'view', 'company', 'admin' => false), array('title' => __l('Business')));?></li>
				<?php endif; ?>
				    <?php if($auth->sessionValid()): ?>
          			<?php if($auth->sessionValid()):?>
					<?php if($auth->user('user_type_id') != ConstUserTypes::Company):?>
						<li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'my_stuff') { echo 'class="active"'; } ?>>
							<?php  echo $html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
						</li>
					<?php elseif($auth->user('user_type_id') == ConstUserTypes::Company): ?>
					<?php if($html->isAllowed($auth->user('user_type_id'))): ?>
						<li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'my_stuff') { echo 'class="active"'; } ?>>
							<?php  echo $html->link(__l('My Stuff'), array('controller' => 'users', 'action' => 'my_stuff'), array('title' => __l('My Stuff')));?>
						</li>
					<?php else: ?>
						<li <?php if($this->params['controller'] == 'transactions' && $this->params['action'] == 'index') { echo 'class="active"'; } ?>>
							<?php  echo $html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('My Transactions')));?>
						</li>
						 <li <?php if($this->params['controller'] == 'companies' && $this->params['action'] == 'edit') { echo 'class="active"'; } ?>>
							 <?php echo $html->link(__l('My Company'), array('controller' => 'companies', 'action' => 'edit',$company['Company']['id']), array('title' => __l('My Company'))); ?>
						 </li>
					<?php endif; ?>
						<?php if($auth->user('user_type_id') == ConstUserTypes::Company && !empty($company['Company'])):?>
							<li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'index' && !empty($this->params['named']['company'])) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('My Deals'), array('controller' => 'deals', 'action' => 'index', 'company' => $company['Company']['slug'] ), array('title' => __l('My Deals')));?></li>
						<?php endif; ?>

						<li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'add') { echo 'class="active"'; } ?>>
                        <?php echo $html->link(__l('Add Deal'), array('controller' => 'deals', 'action' => 'add'), array('class'=>'add-deal', 'title' => __l('Add Deal')));?></li>
					<?php endif; ?>
				<?php endif; ?>
				<?php $url = Router::url(array('controller' => 'users', 'action' => 'my_stuff', 'admin' => false),true); ?>


            <?php endif; ?>
        </ul>
        <div class="menu-right">
        	<?php
				$reg_type_class='normal';
			
          if (!$auth->sessionValid()): ?>
              <ul class="menu-link clearfix">
               <li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'register') { echo 'class="active"'; } ?> ><?php echo $html->link(__l('Join us'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Join us'),'class'=>'login-link'));?></li>
                <li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'login') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Signin'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Signin'),'class'=>'login-link'));?></li>
                 <li class="fconnect">
              	 <?php if(Configure::read('facebook.is_enabled_facebook_connect') && !empty($fb_login_url)):  ?>
					<?php  if (env('HTTPS')) { $fb_prefix_url = 'https://www.facebook.com/images/fbconnect/login-buttons/connect_dark_medium_short.gif';}else{ $fb_prefix_url = 'http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_medium_short.gif';}?>
					<?php echo $html->link($html->image($fb_prefix_url, array('alt' => __l('[Image: Facebook Connect]'), 'title' => __l('Facebook connect'))), $fb_login_url, array('escape' => false,'class'=>'facebook-link')); ?>
            		 <?php endif; ?>
                </li>
              </ul>
               <?php endif; ?>
            <?php if ($auth->sessionValid()): ?>
              <p class="user-login-info">
                    <?php
            			if($auth->user('is_openid_register')):
        							$reg_type_class='open-id';
        						endif;
        						if($auth->user('fb_user_id')):
        							$reg_type_class='facebook';
        						endif;
        						?>
        					<?php
							$current_user_details = array(
								'username' => $auth->user('username'),
								'user_type_id' =>  $auth->user('user_type_id'),
								'id' =>  $auth->user('id'),
								'fb_user_id' =>  $auth->user('fb_user_id')
							);
                         
                            echo __l('Hi, '); ?>
    							<span class="<?php echo $reg_type_class; ?>">
    								<?php echo $html->getUserLink($current_user_details);?>
    							</span>
    						<?php
    						$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
    						echo $html->getUserAvatarLink($current_user_details, 'small_thumb'); ?>

                            <?php
						
                        endif;
                    ?>

				<?php if($auth->sessionValid()): ?>
					<?php if($auth->user('fb_user_id') > 0 && !$session->read('is_normal_login')): ?>
                        <?php echo $html->link(__l('Logout'), $fb_logout_url, array('escape' => false,'class' => 'logout-link')); ?>
                    <?php else: ?>
                        <?php echo $html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'logout-link', 'title' => __l('Logout'))); ?>
                    <?php endif; ?>
			   <?php endif; ?>
			</p>
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
  </div>

    
        <div id="main" class="clearfix">
          <?php
				if ($session->check('Message.error')):
        				$session->flash('error');
        		endif;
        		if ($session->check('Message.success')):
        				$session->flash('success');
        		endif;
				if ($session->check('Message.flash')):
						$session->flash();
				endif;
			?>
			<?php  if ($session->check('Message.TransactionSuccessMessage')):?>
        			<div class="transaction-message info-details ">
						<?php echo $session->read('Message.TransactionSuccessMessage');
							$session->del('Message.TransactionSuccessMessage');
						?>
					</div>
        	<?php  endif; ?>
			<?php if ($this->params['controller'] == 'topic_discussions' && ($this->params['action'] == 'index')):?>
				<?php echo $this->element("../deals/view_compact");?>
			<?php endif;?>
			<?php if (!($this->params['controller'] == 'deals' && ($this->params['action'] == 'view' || ($this->params['action'] == 'index' && empty($this->params['named']['company']))))): ?>
				<div class="side1">
    			    <div class="side1-tl">
                        <div class="side1-tr">
                          <div class="side1-tm"> </div>
                        </div>
                     </div>
                     <div class="side1-cl">
                        <div class="side1-cr">
                            <div class="block1-inner">
                    			<?php endif; ?>
                    			<?php echo $content_for_layout;?>
                    				<?php if (!($this->params['controller'] == 'deals' && ($this->params['action'] == 'view' || ($this->params['action'] == 'index' && empty($this->params['named']['company']))))): ?>
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
			
				<?php
					if ($this->params['controller'] == 'topics' || $this->params['controller'] == 'topic_discussions'):
                    ?>
                    	<div class="side2">
                        <div class="blue-bg1 deal-blue-bg clearfix">
                              <div class="tweet-tl">
                                <div class="tweet-tr">
                                  <div class="tweet-tm">
                                    <h3>tweets around</h3>
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

                    </div>
                <?php	endif;
				?>
				<?php if ($this->params['controller'] == 'deals' && $this->params['action'] == 'buy'):?>
				<div class="side2">
					 <div class="side1-tl">
                        <div class="side1-tr">
                          <div class="side1-tm"> </div>
                        </div>
                     </div>
                     <div class="side1-cl">
                      <div class="side1-cr">
                         <div class="block1-inner">
							<?php echo $this->element('deal-faq', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
                         </div>
                		</div>
            			</div>
                        <div class="side1-bl">
                            <div class="side1-br">
                              <div class="side1-bm"> </div>
                            </div>
                      </div>
				</div>
				<?php endif;?>
			
				</div>

 <div id="footer">
    <div class="footer-tl">
      <div class="footer-tr">
        <div class="footer-tm"> </div>
      </div>
    </div>
    <div class="footer-cl">
      <div class="footer-cr">
        <div class="footer-inner clearfix">
          <div class="footer-wrapper-inner clearfix">
            <div class="footer-section1">
              <div class="footer-left">
                <div class="footer-right">
                 <h6><?php echo __l('Company'); ?></h6>
                </div>
              </div>
              <ul class="footer-nav">
               	<li><?php echo $html->link(__l('About'), array('controller' => 'pages', 'action' => 'view', 'about', 'admin' => false), array('title' => __l('About')));?> </li>
				<li><?php echo $html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact Us')));?></li>
				<li><?php echo $html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions', 'admin' => false), array('title' => __l('Terms & Conditions')));?></li>
              </ul>
            </div>
            <div class="footer-section2">
              <div class="footer-left">
                <div class="footer-right">
                 	<h6><?php echo __l('Learn More'); ?></h6>
                </div>
              </div>
              	<?php $user_type = $auth->user('user_type_id');?>
    			 <ul class="footer-nav">
    				<li><?php echo $html->link(__l('FAQ'), array('controller' => 'pages', 'action' => 'view', 'faq', 'admin' => false), array('title' => __l('FAQ')));?></li>
    				<li><?php echo $html->link(__l('Suggest a business'), array('controller' => 'business_suggestions', 'action' => 'add', 'admin' => false), array('title' => __l('Suggest a business'))); ?></li>
    				<?php if(!$auth->sessionValid()):
    					$url = strstr($this->params['url']['url'],"/company/user/register");?>
    					<li <?php if((!empty($url)) || ($this->params['controller'] == 'pages' && $this->params['action'] == 'view' &&  $this->params['pass'][0] == 'company')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(Configure::read('site.name').' '.__l('for Your Business'), array('controller' => 'pages', 'action' => 'view', 'company', 'admin' => false), array('title' => Configure::read('site.name').' '.__l('for Your Business')));?></li>
    				<?php endif; ?>
    			</ul>
            </div>
            <div class="footer-section3">
              <div class="footer-left">
                <div class="footer-right">
                	<h6><?php echo __l('Follow Us'); ?></h6>
                </div>
              </div>
              <ul class="footer-nav">
                 	<?php
    					if(!empty($city_slug)):
    						$tmpURL= $html->getCityTwitterFacebookURL($city_slug);
    					endif;
    				?>

    				<li class="face2"><a href="<?php echo !empty($tmpURL['City']['facebook_url']) ? $tmpURL['City']['facebook_url'] : Configure::read('facebook.site_facebook_url'); ?>" title="<?php echo __l('See Our Profile in Facebook'); ?>" target="_blank"><?php echo __l('Facebook'); ?></a></li>
                    <li class="tweet2"><a href="<?php echo !empty($tmpURL['City']['twitter_url']) ? $tmpURL['City']['twitter_url'] : Configure::read('twitter.site_twitter_url'); ?>" title="<?php echo __l('Follow Us in Twitter'); ?>" target="_blank"><?php echo __l('Twitter'); ?></a></li>
                	<?php if($html->isAllowed($auth->user('user_type_id'))):?>
    				<li class="mail2"><?php echo $html->link(__l('Email'), array('controller' => 'subscriptions', 'action' => 'add', 'admin' => false), array('title' => __l('Email'))); ?></li>
    				<?php endif;?>
    					<?php
                    $cityArray = array();
					if(!empty($city_slug)):
						$tmpURL= $html->getCityTwitterFacebookURL($city_slug);
						$cityArray = array('city'=>$city_slug);
					endif;
				?>
    			     <li class="rss2"><?php echo $html->link(__l('RSS'), array_merge(array('controller'=>'deals', 'action'=>'index', 'ext'=>'rss'), $cityArray), array('target' => '_blank','title'=>__l('RSS Feed'))); ?></li>
               </ul>
            </div>
            
                	<?php
					if (Configure::read('site.is_mobile_app')): ?>
                    <div class="mobile-left">
                     <div class="mobile-right">
                        <?php $url = 'http://m.' . str_replace('www.', '', env('HTTP_HOST'));
    					echo $html->link(__l('Mobile/PDA Version'), $url, array('class' => 'mobile')); ?>
                    </div>
                  </div>
				<?php endif; ?>
            
          </div>
          <div id="agriya" class="clearffix">
          	<p class="copy">&copy;<?php echo date('Y');?> <?php echo $html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	<?php echo $this->element('site_tracker', array('cache' => array('time' => Configure::read('site.element_cache')), 'plugin' => 'site_tracker')); ?>
	<?php echo $cakeDebug?>
</body>
</html>
