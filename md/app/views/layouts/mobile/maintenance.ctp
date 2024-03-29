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
		require_once('_head.inc.ctp');
		echo $asset->scripts_for_layout();
	?>
</head>
<body>
	<div id="<?php echo $html->getUniquePageId();?>" class="content">
		<div id="header" class="clearfix">
			<h1><?php echo $html->link(Configure::read('site.name'), '/');?></h1>
			<div id="sub-header">
				<p class="welcome-block clearfix">
					<span><?php	echo __l('Welcome, Guest'); ?></span>
				</p>
                <div class="menu-block clearfix">
                    <ul class="menu clearfix">
                        <li <?php if($this->params['controller'] == 'deals' && $this->params['action'] == 'index' && !isset($this->params['named']['type']) && !isset($this->params['named']['company'])) { echo 'class="active"'; } ?>><?php echo $html->link(__l('Today\'s Deals'), array('controller' => 'deals', 'action' => 'index', 'admin' => false), array('title' => __l('Today\'s Deals')));?></li>
                        <li <?php if($this->params['controller'] == 'deals' && (isset($this->params['named']['type']) && $this->params['named']['type'] == 'recent')) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Recent Deals'), array('controller' => 'deals', 'action' => 'index', 'admin' => false,'type' => 'recent'), array('title' => __l('Recent Deals')));?></li>
                            <li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'register' && !empty($type)) { echo 'class="active"'; } else { echo 'class=""';}?>><?php echo $html->link(__l('Company'), array('controller' => 'pages', 'action' => 'view', 'company-register', 'admin' => false), array('title' => __l('Company')));?></li>
                            
                            <li <?php if($this->params['controller'] == 'topics' && $this->params['action'] == 'topic_discussions') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Discussion'), array('controller' => 'topics', 'action' => 'index'), array('title' => __l('Discussion')));?></li>
                        <li <?php if($this->params['controller'] == 'pages' && $this->params['action'] == 'view'  && $this->params['pass'][0] == 'learn') { echo 'class="active"'; } ?>><?php echo $html->link(sprintf(__l('How %s Works'), Configure::read('site.name')), array('controller' => 'pages', 'action' => 'view', 'learn'), array('title' => sprintf(__l('How %s Works'), Configure::read('site.name'))));?></li>
                            <li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'login') { echo 'class="active"'; } ?>><?php echo $html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));?></li>
                </ul>
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
			<div class="footer-wrapper-inner">
				<div class="footer-section1">
					<h6><?php echo __l('Company'); ?></h6>
					<ul class="footer-nav">
						<li><?php echo $html->link(__l('About'), array('controller' => 'pages', 'action' => 'view', 'about', 'admin' => false), array('title' => __l('About')));?> </li>
						<li><?php echo $html->link(__l('Contact us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact us')));?></li>
						<li><?php echo $html->link(__l('Terms & Policies'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions', 'admin' => false), array('title' => __l('Terms, Privacy, Returns, Etc.')));?></li>
					</ul>
				</div>
				<div class="footer-section2">
					<h6><?php echo __l('Learn More'); ?></h6>
					<ul class="footer-nav">
						<li><?php echo $html->link(__l('FAQ'), array('controller' => 'pages', 'action' => 'view', 'faq', 'admin' => false), array('title' => __l('FAQ')));?></li>
					</ul>
				</div>
				<div class="footer-section4">
					<h6><?php echo __l('Follow Us'); ?></h6>
					<ul class="footer-nav">
						<?php $tmpURL= $html->getCityTwitterFacebookURL($city_slug); ?>
						<li><a href="<?php echo ($tmpURL['City']['twitter_url']) ? $tmpURL['City']['twitter_url'] : Configure::read('twitter.site_twitter_url'); ?>" title="<?php echo __l('Follow Us in Twitter'); ?>" target="_blank"><?php echo __l('Twitter'); ?></a></li>
						<li><a href="<?php echo ($tmpURL['City']['facebook_url']) ? $tmpURL['City']['facebook_url'] : Configure::read('facebook.site_facebook_url'); ?>" title="<?php echo __l('See Our Profile in Facebook'); ?>" target="_blank"><?php echo __l('Facebook'); ?></a></li>
						<li><?php echo $html->link(__l('Subscribe to Daily Email'), array('controller' => 'subscriptions', 'action' => 'add', 'admin' => false), array('title' => __l('Subscribe to Daily Email'))); ?></li>
						<li><?php echo $html->link(__l('Topics'), array('controller' => 'topics', 'action' => 'index', 'admin' => false), array('title' => __l('Topics'))); ?></li>
					</ul>
				</div>
				<h6 class="logo"><?php echo $html->link(Configure::read('site.name'), array('controller' => 'deals', 'action' => 'index'), array('title' => Configure::read('site.name')))?></h6>
				<p class="caption"><?php echo __l('Collective Buying Power');?></p>				
			</div>
			<div id="agriya" class="clearfix">
				<p>&copy;<?php echo date('Y');?> <?php echo $html->link(Configure::read('site.name'), '/');?>. <?php echo __l('All rights reserved');?>.</p>
			</div>
		</div>
	</div>
	<?php echo $cakeDebug?>
</body>
</html>
