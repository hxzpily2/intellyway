<?php /* SVN: $Id: admin_add.ctp 6876 2010-06-04 02:36:48Z subingeorge_082at09 $ */ ?>
<div class="bannedIps form">
    <h2><?php echo __l('Add Ban'); ?></h2>
    <div class="js-corner round-5" id="form-content">
        <?php echo $form->create('BannedIp', array('class' => 'normal'));?>
		<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Current User Information'); ?></legend>
		  	<dl class="list">
				<dt><?php echo __l('Your IP: ');?></dt>
					<dd><?php echo $ip;?></dd>
        		<dt><?php echo __l('Your Hostname: ');?></dt>
					<dd><?php echo gethostbyaddr($ip);?></dd>
			</dl>    	     
		 </fieldset>
		 <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Ban Type'); ?></legend>
        	<div>
                
                <?php echo $form->input('type_id', array('type' => 'radio', 'label' => __l('Select method'),'legend' => false));?>
                <?php echo $form->input('address', array('label' => __l('Address/Range'))); ?>
                <?php echo $form->input('range', array('label' => false, 'after' => __l('(IP address, domain or hostname)'))); ?>
            </div>
			 <div class="info-details">
            	<h3><?php echo __l('Possibilities:'); ?></h3>
               	<div>
        			<p><?php echo __l('- Single IP/Hostname: Fill in either a hostname or IP address in the first field.'); ?></p>
        			<p><?php echo __l('- IP Range: Put the starting IP address in the left and the ending IP address in the right field.'); ?></p>
        			<p><?php echo __l('- Referer block: To block google.com put google.com in the first field. To block google altogether.'); ?></p>
                </div>
            </div>
         </fieldset>
		<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Ban Details'); ?></legend>
            <?php
        		echo $form->input('reason', array('label' => __l('Reason'),'info' => __l('(optional, shown to victim)')));
        		echo $form->input('redirect', array('label' => __l('Redirect'),'info' => __l('(optional)')));
        		echo $form->input('duration_id', array('label' => __l('How long')));
        		echo $form->input('duration_time', array('label' => false, 'info' => __l('Leave field empty when using permanent. Fill in a number higher than 0 when using another option!')));
        	?>
        	<div class="info-details">
        		<h3><?php echo __l('Hints and tips:'); ?></h3>
        		<div>
            		<p><?php echo __l('- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won\'t work.'); ?></p>
            		<p><?php echo __l('- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!'); ?></p>
            		<p><?php echo __l('- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!'); ?></p>
            		<p><?php echo __l('- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!'); ?></p>
            		<p><?php echo __l('- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!'); ?></p>
            		<p><?php echo __l('- If a ban does not seem to work try to find out if the person you\'re trying to ban doesn\'t use <a href="http://en.wikipedia.org/wiki/DHCP" target="_blank" title="DHCP">DHCP.</a>'); ?></p>
                </div>
        	</div>
			</fieldset>
			

        <div class="submit-block clearfix">
		<?php echo $form->submit(__l('Add'));?>
        <div class="cancel-block">
            <?php echo $html->link(__l('Cancel'), array('controller' => 'banned_ips', 'action' => 'index'), array('class' => 'cancel-link', 'title' => __l('Cancel'), 'escape' => false));?>
        </div>
	</div>
    <?php echo $form->end(); ?>
    </div>
</div>