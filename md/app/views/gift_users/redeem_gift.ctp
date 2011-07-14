<?php /* SVN: $Id: redeem_gift.ctp 15349 2010-07-24 09:31:48Z siva_063at09 $ */ ?>
<div class="giftUsers form js-responses">
        <?php echo $form->create('GiftUser', array('action' => 'redeem_gift','class' => "normal js-ajax-form"));?>
		<div class="clearfix">
        	<div class="gift-form">
        	<?php
                echo $form->input('coupon_code',array('label' => __l('Redemption Code')));
                echo $form->input('submit',array('type' => 'hidden'));
			?>
				</div>
				</div>
			<div class="submit-block clearfix">
                 <?php echo $form->submit(__l('Redeem'),array('name' => 'data[GiftUser][submit]'));?>
                
				 <div class="cancel-block">
					<?php echo $html->link(__l('Cancel'), '#', array('class' => "cancel-button js-toggle-show {'container':'js-redeem-form'}"));?>
                 </div>
			</div>
		
			<?php echo $form->end();?>
        
			
</div>
