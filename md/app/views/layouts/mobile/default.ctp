<?php
/* SVN FILE: $Id: default.ctp 7805 2008-10-30 17:30:26Z AD7six $ */
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
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $html->cText($title_for_layout, false);?></title>
	<?php
		echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
		require_once('_mobile_head.inc.ctp');
		echo $asset->scripts_for_layout();
	?>
</head>
<body>
    <div id="<?php echo $html->getUniquePageId();?>" class="content">
      <div id="header">
         <h1>
				<?php
					echo $html->link($html->Image('mobile/logo-blue.png', array('alt' => sprintf(__l('[Image: %s]'), Configure::read('site.name')), 'title' => Configure::read('site.name'), 'type' => 'png')), array('controller' => 'deals', 'action' => 'index', 'admin' => false), array('escape' => false));
				?>
			</h1>
        <div class="clearfix">
		<?php if(!empty($city_name)): ?>
			<div class="header-bot-l">
				<h3><?php echo __l('Daily Deals on the Best in'); ?>
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix') {
							echo $html->link($html->cText($city_name), array('controller' => 'deals', 'action' => 'index', 'city' => $city_slug), array('title' => $html->cText($city_name, false), 'escape' => false));
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
				</h3>
				<?php echo $html->link(__l('Visit More Cities'),array('controller' => 'cities', 'action' => 'index'),array('title'=>__l('Visit More Cities'))); ?>
		
			<?php endif;?>
		
            	</div>
			
             <?php if($auth->sessionValid()): ?>
                    <div class="header-bot-r">
                    	<?php echo $this->element('lanaguge-change-block', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
                        <dl class="total-list clearfix">
                        	<dt><?php echo __l('Balance: '); ?></dt>
                            <dd><span><?php echo $html->siteCurrencyFormat($html->cCurrency($user_available_balance)); ?></span></dd>
                        </dl>
						<?php if ((Configure::read('company.is_user_can_withdraw_amount') && $auth->user('user_type_id') == ConstUserTypes::Company) || (Configure::read('user.is_user_can_with_draw_amount') && $auth->user('user_type_id') == ConstUserTypes::User)) { ?>
                            <p class="add-amount">
                            <?php echo $html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request'),'class'=>'width-draw'));?>
                            </p>
                        <?php } ?>
                        <?php if($html->isAllowed($auth->user('user_type_id'))): ?>
                            <p class="add-amount"><?php echo $html->link(__l('Add amount to wallet'), array('controller' => 'users', 'action' => 'add_to_wallet'), array('class' => 'add add-wallet', 'title' => __l('Add amount to wallet'))); ?></p>
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
				<li <?php if($this->params['controller'] == 'topics' && $this->params['action'] == 'index') { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Discussion'), array('controller' => 'topics', 'action' => 'index'), array('title' => __l('Discussion')));?></li>
				
				<li <?php if($this->params['controller'] == 'pages' && $this->params['action'] == 'view'  && $this->params['pass'][0] == 'learn') { echo 'class="active"'; } ?>><?php echo $html->link(sprintf(__l('How')." ".'%s'." " .__l('Works'), Configure::read('site.name')), array('controller' => 'pages', 'action' => 'view', 'learn'), array('title' => sprintf(__l('How')." ".'%s'." ".__l(' Works'), Configure::read('site.name'))));?></li>

				<?php if(!$auth->sessionValid()):?>	
					<li <?php if($this->params['controller'] == 'pages' && $this->params['action'] == 'view' &&  $this->params['pass'][0] == 'company') { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Business'), array('controller' => 'pages', 'action' => 'view', 'company', 'admin' => false), array('title' => __l('Business')));?></li>
				<?php endif; ?>
			</ul>            
            <div class="menu-right">                 
            <p class="user-login-info">
                    <span class="user">            
							<?php
						$reg_type_class='normal';
						if (!$auth->sessionValid()):							
                            echo __l('Hi, Guest');
                            ?>
           					<span class="welcome-info">
            				   <span <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'login') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'),'class'=>'login-link'));?></span>
    	           			   / <span <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'register') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Register'),'class'=>'login-link'));?></span>
            				 </span>
                            <?php
                          else:
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
                            if($auth->user('user_type_id') != ConstUserTypes::Admin):
                                    echo __l('Hi, '); ?>
										<span class="<?php echo $reg_type_class; ?>">
											<?php echo $html->getUserLink($current_user_details);?>
										</span> 
									<?php
									$current_user_details['UserAvatar'] = $html->getUserAvatar($auth->user('id'));
									echo $html->getUserAvatarLink($current_user_details, 'small_thumb');
                            else:?>
								<span class="<?php echo $reg_type_class; ?>">
									<?php echo $html->getUserLink($current_user_details);?>
								</span> 
                            <?php
							endif;
                        endif;
                    ?>
                
				<?php if($auth->sessionValid()): ?>
					<?php if($auth->user('fb_user_id') > 0): ?>
                        <?php 
						$redirect_url= array(
							'controller' => 'users',
							'action' => 'logout'
						);
						if(!empty($this->params['named']['city'])):
							$redirect_url['city'] = $this->params['named']['city'];
						endif;
						$logout_url = Router::url($redirect_url, true);
						echo $html->link(__l('Logout'), '#', array('onclick' => 'FB.Connect.logout(function() { document.location = \''.$logout_url.'\'; }); return false;')); ?>
                    <?php else: ?>
                        <?php echo $html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'logout-link', 'title' => __l('Logout')));?>
                    <?php endif; ?>
				<?php endif; ?>
				</span>
            </p>
            <?php if($auth->sessionValid()): ?>
              	<ul class="user-menu">
					
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
										 <li <?php if($this->params['controller'] == 'companies' && $this->params['action'] == 'edit') { echo 'class="active"'; } ?>>
											 <?php echo $html->link(__l('My Company'), array('controller' => 'companies', 'action' => 'edit',$user['Company']['id']), array('title' => __l('My Account'))); ?>
										 </li>
									<?php endif; ?>
								<?php 
									$user = $html->getCompany($auth->user('id'));
									?>					
								<?php if($auth->user('user_type_id') == ConstUserTypes::Company && !empty($user['Company'])):?>
									<li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'index' && !empty($this->params['named']['company'])) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('My Deals'), array('controller' => 'deals', 'action' => 'index', 'company' => $user['Company']['slug'] ), array('title' => __l('My Deals')));?></li>
								<?php endif; ?>
								
								<li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'add') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Add Deal'), array('controller' => 'deals', 'action' => 'add'), array('class'=>'add-deal', 'title' => __l('Add Deal')));?></li>
							<?php endif; ?>	
						<?php endif; ?>
						<?php $url = Router::url(array('controller' => 'users', 'action' => 'my_stuff', 'admin' => false),true); ?>
					
              </ul>
            <?php endif; ?>
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
			<?php echo $content_for_layout;?>
	  </div>
 		<div id="footer">
			<div id="agriya" class="clearfix">
				<p>&copy;<?php echo date('Y');?>
                <?php echo $html->link(Configure::read('site.name'), Router::url('/', true));?>. <?php echo __l('All rights reserved');?>.
                </p>
			</div>
			<?php
			 	$parsed_url = parse_url(Router::url('/', true));
			 	$mobile_site_url = str_ireplace('m.', '', Router::url('/', true));
			 	echo $html->link(__l('Regular Version'), $mobile_site_url);
			 ?>
		</div>
	</div>
</body>
</html>
