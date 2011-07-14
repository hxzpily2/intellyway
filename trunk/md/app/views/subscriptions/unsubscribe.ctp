<?php /* SVN: $Id: unsubscribe.ctp 32532 2010-11-08 14:57:19Z saranya_127act10 $ */ ?>
<?php echo $form->create('Subscription', array('url'=>array('action'=>'unsubscribe'),'class' => 'normal'));?>
	<fieldset>
    	<h2><?php echo __l('Manage Your Subscription'); ?></h2>
        <div class="wallet-amount-block">
			<?php 
                echo __l('Are sure you want to unsubscribe?');
                echo $form->input('id',array('type' => 'hidden'));
            ?>
        </div>
	<div class="submit-block clearfix">
		<?php echo $form->submit(__l('Unsubscribe'), array('title' => __l('Unsubscribe'))); ?>
        <div class="cancel-block">
            <?php echo $html->link(__l('Oops, i changed my mind'), array('controller'=>'deals','action' => 'index'), array('class' => 'cancel-button', 'title' => __l('Oops, i changed my mind'))); ?>
        </div>
    </div>
    <?php echo $form->end();?>
	</fieldset>