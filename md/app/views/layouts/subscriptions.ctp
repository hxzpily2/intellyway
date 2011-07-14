<?php
/* SVN FILE: $Id: default.ctp 17321 2010-08-03 15:43:55Z aravindan_111act10 $ */
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
		require_once('_head.inc.ctp');
		echo $asset->scripts_for_layout();
	?>
</head>
<body class="subscription">
	<div id="<?php echo $html->getUniquePageId();?>">
       <div class="clearfix">
            <h1>
				<?php
					$attachment = $html->siteLogo();
					if (!empty($attachment['Attachment'])):
						echo $html->link($html->showImage('SiteLogo', $attachment['Attachment'], array('dimension' => 'site_logo_thumb', 'alt' => sprintf(__l('[Image: %s]'), Configure::read('site.name')), 'title' => Configure::read('site.name'), 'type' => 'png')), array('controller' => 'deals', 'action' => 'index', 'admin' => false), array('escape' => false));
					endif;
				?>
			</h1>
            <p class="hidden-info"><?php echo __l('Collective Buying Power');?></p>
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
			<div class="footer-wrapper-inner clearfix">
				<div id="agriya" class="clearffix">
					<p>&copy;<?php echo date('Y');?> <?php echo $html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
				</div>
				<div class="footer-r">
					<?php echo $this->element('subscription-index', array('cache' => array('time' => Configure::read('site.element_cache')))); ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->element('site_tracker', array('cache' => array('time' => Configure::read('site.element_cache')), 'plugin' => 'site_tracker')); ?>
	<?php echo $cakeDebug?>
</body>
</html>
