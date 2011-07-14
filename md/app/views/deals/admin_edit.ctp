<?php /* SVN: $Id: admin_edit.ctp 44816 2011-02-19 12:02:30Z aravindan_111act10 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
<div class="deals form js-responses">
<?php echo $form->create('Deal', array('class' => 'normal js-upload-form {is_required:"false"}', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
    <h2><?php echo __l('Edit Deal');?></h2>
	<div class="js-validation-part">
   <fieldset class="form-block round-5">
    <legend class="round-5"><?php echo __l('General'); ?></legend>
    <?php echo $html->link($html->showImage('Deal', $this->data['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($this->data['Deal']['name'], false)), 'title' => $html->cText($this->data['Deal']['name'], false))), array('controller' => 'deals', 'action' => 'view',  $deal['Deal']['slug'], 'admin' => false), null, null, false); ?>
	<?php
		echo $form->input('id');
		echo $form->input('name',array('label' => __l('Name')));
		echo $form->input('company_id', array('label' => __l('Company'),'empty' => 'Please Select'));
		echo $form->input('is_anytime_deal', array('label' => __l('Any Time Deal'), 'info' => __l('This type of deal doesn\'t have closing date or expiry date. It can only be closed manually by Site Administrator or Specifying Maximum Buy Quantity')));
	?>
			<div class="clearfix date-time-block">
					<div class="input date-time clearfix required">
						<div class="js-datetime">
							<?php echo $form->input('start_date', array('label' => __l('Start Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
						</div>
					</div>
					<div class="input date-time end-date-time-block clearfix required js-anytime-deal">
						<div class="js-datetime">
							<?php echo $form->input('end_date', array('label' => __l('End Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
						</div>
					</div>
				</div>
			<div class="clearfix date-time-block">
					<div class="input date-time clearfix required">
						<div class="js-datetime">
							<?php echo $form->input('coupon_start_date', array('label' => __l('Coupon Start Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
						</div>
					</div>
					<div class="input date-time end-date-time-block clearfix required js-anytime-deal">
						<div class="js-datetime">
							<?php echo $form->input('coupon_expiry_date', array('label' => __l('Coupon End Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
						</div>
					</div>
				</div>
            	<div class="clearfix input-blocks">
            	    <div class=" input-block-left">
                    <?php
   						echo $form->input('min_limit', array('label'=>__l('No. of min. coupons'), 'info' => __l('Minimum limit of coupons to be bought by users, in order for the deal to get tipped.'))); ?>

			         </div>
			        <div class="input-block-right ">
					  <?php	echo $form->input('max_limit', array('label'=>__l('No. of max. coupons'), 'info' => __l('Maximum limit of coupons can be bought for this deal. Leave blank for no limit.'))); ?>
                    </div>

             </div>
               <div class="clearfix input-blocks">
                <div class=" input-block-left">
                     <?php 	echo $form->input('buy_min_quantity_per_user', array('label'=>__l('Minimum Buy Quantity'),'info' => __l('How much minimum coupons user should buy for himself. Default 1'))); ?>
                </div>
    			<div class="input-block-right ">
                      <?php	echo $form->input('buy_max_quantity_per_user', array('label'=>__l('Maximum Buy Quantity'),'info' => __l('How much coupons user can buy for himself. Leave blank for no limit.'))); ?>
               </div>
    	   </div>
    	<?php if(Configure::read('deal.is_side_deal_enabled')): ?>
                <?php echo $form->input('is_side_deal', array('label'=>__l('Side Deal'), 'info'=>__l('Side deals will be displayed in the side bar of the home page.')));?>
        <?php endif; ?>
        </fieldset>
		<fieldset class="form-block round-5 js-deal-cities">
			<legend class="round-5"><?php echo __l('Deal Cities'); ?></legend>
			<div class="input cities-block required">
            <label><?php echo __l('Cities');?></label>
			</div>
			<?php 
				if(empty($this->data['Deal']['City'])): ?>
					<div class="cities-checkbox-block">
				<?php
					echo $form->input('City',array('label' =>false,'multiple'=>'checkbox'));
                ?>
                </div>
                <?php
                else:
                ?>
                	<div class="cities-checkbox-block">
                <?php
					echo $form->input('City',array('label' =>false,'multiple'=>'checkbox','value'=>$city_id));
                ?>
                </div>
                <?php
            	endif;
			?>
		</fieldset>  
		<?php
			if(Configure::read('site.currency_symbol_place') == 'left'):
				$currecncy_place = 'before';
			else:
				$currecncy_place = 'after';
			endif;	
		?>
		<fieldset class="form-block round-5">

		<legend class="round-5"><?php echo __l('Price'); ?></legend>
        <?php echo $form->input('original_price',array('label' => __l('Original Price'),'class' => 'js-price', $currecncy_place => Configure::read('site.currency'))); ?>
			<div class="two-col-form clearfix">
			<?php echo $form->input('discount_percentage', array('label' => __l('Discount (%)'))); ?>
			<span class="sep-or"><?php echo __l('OR'); ?></span>
			<?php echo $form->input('discount_amount', array('label' => __l('Discount Amount'), $currecncy_place => Configure::read('site.currency'))); ?>
			</div>
			<?php echo $form->input('savings', array('type'=>'text',  'label' => __l('Savings for user'),  'readonly' => 'readonly',$currecncy_place => Configure::read('site.currency')));
			echo $form->input('discounted_price', array('label' => __l('Discounted Price for user'),'type'=>'text', 'readonly' => 'readonly',$currecncy_place => Configure::read('site.currency')));
		?>
		</fieldset>
		<fieldset class="form-block round-5">
       <legend class="round-5"><?php echo __l('Commission'); ?></legend>
        <div class="page-info"><?php echo __l('Total Commission Amount = Bonus Amount + ((Discounted Price * Number of Buyers) * Commission Percentage/100))'); ?></div>
		<div class="clearfix">
	   <div class="amount-block commision-form-block">
        <?php
		echo $form->input('bonus_amount', array('label' => __l('Bonus Amount'),$currecncy_place => Configure::read('site.currency'), 'info' => __l('This is the flat fee that the company will pay for the whole deal.')));
		echo $form->input('commission_percentage', array('info' => __l('This is the commission that company will pay for the whole deal in percentage.')));
		if($auth->user('user_type_id') == ConstUserTypes::Admin):
			echo $form->input('private_note', array('type' =>'textarea', 'label' => __l('Private Note'), 'info' => __l('This is for admin reference. It will not be displayed for other users.')));
		endif;
		?>
		</div>
		<div class="calculator-block round-5">
        <?php echo $this->element('../deals/commission_calculator', array('cache' => array('time' => Configure::read('site.element_cache'), 'key' => $auth->user('id'))));;?>
		</div>
        </div>



        <?php
			echo $form->input('description', array('label' => __l('Description'),'type' =>'textarea', 'class' => 'js-editor'));
		?>
				
        <div class="clearfix attachment-delete-outer-block">
			<ul>
				<?php 
					foreach($this->data['Attachment'] as $attachment){ 
				?>
					<li>	
					<div class="attachment-delete-block">
					  <span class="delete-photo"> <?php echo __l('Delete Photo'); ?></span>

					<?php	
						echo $form->input('OldAttachment.'.$attachment['id'].'.id', array('type' => 'checkbox', 'class'=>'js-gig-photo-checkbox','id' => "gig_checkbox_".$attachment['id'], 'label' => false));
						echo $html->showImage('Deal', $attachment, array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($this->data['Deal']['name'], false)), 'title' => $html->cText($this->data['Deal']['name'], false)));
					?>
					</div>
					</li>
				<?php } ?>
			</ul>
        </div>
	</div>
	   <fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Deal Image'); ?></legend>
		<?php
			echo $form->uploader('Attachment.filename', array('type'=>'file', 'uController' => 'deals', 'uRedirectURL' => array('controller' => 'deals', 'action' => 'index', 'admin' => true), 'uId' => 'dealID', 'uFiletype' => Configure::read('photo.file.allowedExt')));
		?>
		</fieldset>
	   <fieldset class="form-block round-5">
        <legend class="round-5"><?php echo __l('Review'); ?></legend>
		<?php
			//echo $form->input('Attachment.filename', array('type' => 'file', 'label' => __l('Product Image')));
			echo $form->input('review', array('label' => __l('Review'),'type' =>'textarea', 'class' => 'js-editor'));
		?>
		</fieldset>
        <fieldset class="form-block round-5">
        <legend class="round-5"><?php echo __l('Coupon'); ?></legend>
		<?php
			echo $form->input('coupon_condition', array('label' => __l('Coupon Condition'),'type' =>'textarea', 'class' => 'js-editor'));
			echo $form->input('coupon_highlights', array('label' => __l('Coupon Highlights'),'type' =>'textarea', 'class' => 'js-editor'));
			echo $form->input('comment', array('label' => __l('Comment'),'type' =>'textarea', 'class' => 'js-editor'));
		?>
        </fieldset>
        <fieldset class="form-block round-5">
        <legend class="round-5"><?php echo __l('SEO'); ?></legend>
        <?php
			echo $form->input('meta_keywords',array('label' => __l('Meta Keywords')));
			echo $form->input('meta_description',array('label' => __l('Meta Description')));
	?>
    </fieldset>
	</fieldset>
    <div class="submit-block">
<?php echo $form->submit(__l('Update'),array('name' => 'data[Deal][send_to_admin]')); ?>
    <div class="cancel-block">
		<?php
			if($deal['Deal']['deal_status_id'] == ConstDealStatus::Draft):
				echo $form->submit(__l('Update Draft'));
			endif;
			echo $html->link(__l('Cancel'), array('controller' => 'deals', 'action' => 'index', 'admin' => true), array('class' => 'cancel-button'));

		?>
    </div>
    </div>
    <?php echo $form->end(); ?>
</div>
