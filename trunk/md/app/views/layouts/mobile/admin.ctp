<?php
/* SVN FILE: $Id: admin.ctp 6910 2010-06-04 07:28:35Z sreedevi_140ac10 $ */
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo sprintf(__l('Admin - %s'), $html->cText($title_for_layout, false)); ?></title>
	<?php
		echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
		require_once('_mobile_head.inc.ctp');
		echo $asset->scripts_for_layout();
	?>
</head>
<body class="admin">
	<div id="<?php echo $html->getUniquePageId();?>" class="content admin-content">
		<div id="header" class="clearfix">
		    <div id="header-content">
			<div class="clearfix">
			<h1>
				<?php
					$attachment = $html->siteLogo();
					if (!empty($attachment['Attachment'])):
						echo $html->link($html->showImage('SiteLogo', $attachment['Attachment'], array('dimension' => 'site_logo_thumb', 'alt' => sprintf(__l('[Image: %s]'), Configure::read('site.name')), 'title' => Configure::read('site.name'), 'type' => 'png')), array('controller' => 'deals', 'action' => 'index','admin' => false), array('escape' => false));
					endif;
				?>
			</h1>
			 <?php
                    $languages = $html->getLanguage();
                    if(Configure::read('user.is_allow_user_to_switch_language') && !empty($languages)) :
                        echo $form->create('Language', array('url' => array('action' => 'change_language','admin' => false), 'class' => 'language-form'));
                        echo $form->input('language_id', array('label' => __l('Language'),'class' => 'js-autosubmit', 'options' => $languages, 'value' => Configure::read('lang_code')));
                        echo $form->input('r', array('type' => 'hidden', 'value' => $this->params['url']['url']));
                        ?>
                        <div class="hide">
                            <?php echo $form->submit('Submit');  ?>
                        </div>
                        <?php
                        echo $form->end();
                    endif;
                ?>
			 <div class="admin-bar clearfix">
                <div class="clearfix"><h3><?php echo __l('Current time: '); ?></h3><?php echo $html->cTime(date(Configure::read('site.datetime.format'))); ?></div>
        		<div class="clearfix"><h3><?php echo __l('Last login: '); ?></h3><?php echo $html->cDateTimeHighlight($auth->user('last_logged_in_time')); ?></div>
    		</div>
			<div id="sub-header" class="admin-sub-header">
			 <p class="admin-welcome-info"><?php echo __l('Welcome, ').$html->link($auth->user('username'), array('controller' => 'users', 'action' => 'stats', 'admin' => true),array('title' => $auth->user('username'))); ?></p>
				
			</div>
	
			</div>
			<ul class="menu">
				  <li><?php echo $html->link(__l('Home'), array('controller' => 'deals', 'action' => 'index','admin' => false), array('escape' => false, 'title' => __l('Home')));?></li>
				   <?php $class = (($this->params['controller'] == 'user_profiles') && ($this->params['action'] == 'my_account')) ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'user_account', $auth->user('id')), array('title' => __l('My Account')));?></li>
					<li><?php echo $html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?></li>
				</ul>
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
            <div class="admin-sideone js-corner round-10">
                <?php
                    echo $this->element('admin-sidebar', array('cache' => array('time' => Configure::read('site.element_cache')) ));
                ?>
            </div>
            <div class="admin-sidetwo js-corner round-10">
    			<?php echo $content_for_layout;?>
			</div>
		</div>
		<div id="footer">
			<div id="agriya" class="clearfix">
				<p>&copy;<?php echo date('Y');?> <?php echo $html->link(Configure::read('site.name'), '/');?>. <?php echo __l('All rights reserved');?>.</p>
			</div>
		</div>
	</div>
	<?php echo $this->element('site_tracker');?>
	<?php echo $cakeDebug?>
</body>
</html>
