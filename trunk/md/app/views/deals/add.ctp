<?php /* SVN: $Id: add.ctp 44816 2011-02-19 12:02:30Z aravindan_111act10 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
<div class="deals form js-responses">
<?php 
if(empty($this->data['CloneAttachment'][0])) 
	echo $form->create('Deal', array('action' => 'add', 'class' => 'normal js-upload-form {is_required:"true"}', 'enctype' => 'multipart/form-data'));
else
	echo $form->create('Deal', array('action' => 'add', 'class' => 'normal js-upload-form {is_required:"false"}', 'enctype' => 'multipart/form-data'));	
?>

	<div class="js-validation-part">
    <h2><?php echo __l('Add Deal');?></h2>
	<?php if($auth->user('user_type_id') == ConstUserTypes::Company):?>
		<div class="adddeal-img-block"><?php echo $html->image('company-deal-flow.jpg', array('alt'=> __l('[Image: Company Deal Flow]'), 'title' => __l('Company Deal Flow'))); ?></div>
	<?php else: ?>
		<div class="adddeal-img-block"> <?php echo $html->image('admin-deal-flow.jpg', array('alt'=> __l('[Image: Administrator Deal Flow]'), 'title' => __l('Administrator Deal Flow'))); ?></div>
	<?php endif; ?>
	   <fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('General'); ?></legend>
		<?php
			echo $form->input('user_id', array('type' => 'hidden'));
			echo $form->input('clone_deal_id', array('type' => 'hidden'));
			echo $form->input('name',array('label' => __l('Name')));
			if($auth->user('user_type_id') == ConstUserTypes::Admin):
				echo $form->input('company_id', array('label' => __l('Company'),'empty' =>__l('Please Select')));
				echo $form->input('company_slug', array('type' => 'hidden'));
			else:
				echo $form->input('company_id', array('type' => 'hidden'));
				echo $form->input('company_slug', array('type' => 'hidden'));
			endif;
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
						<?php
						echo $form->input('buy_min_quantity_per_user', array('label'=>__l('Minimum Buy Quantity'),'info' => __l('Minimum purchase per user including gifts.')));
						?>
					</div>
				<div class="input-block-right ">
					<?php
					echo $form->input('buy_max_quantity_per_user', array('label'=>__l('Maximum Buy Quantity'),'info' => __l('Maximum purchase per user including gifts. Leave blank for no limit.')));
			   ?>
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
				if(empty($this->data['Deal']['City']) && empty($city_id)): ?>
					<div class="cities-checkbox-block clearfix">
                        <?php
    					echo $form->input('City',array('label' =>false,'multiple'=>'checkbox')); ?>
					</div>
					<?php
				else:
                 ?>
                 <div class="cities-checkbox-block clearfix">
                 <?php
					echo $form->input('City',array('label' => false,'multiple'=>'checkbox','value'=>$city_id));
                ?>
                	</div>
                <?php
            	endif;
			?>
		
		</fieldset>  
		   <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Price'); ?></legend>
				<?php
					if(Configure::read('site.currency_symbol_place') == 'left'):
						$currecncy_place = 'before';
					else:
						$currecncy_place = 'after';
					endif;	
				?>
				<?php
					echo $form->input('original_price',array('label' => __l('Original price'),'class' => 'js-price', $currecncy_place => Configure::read('site.currency'))); ?>
					<div class="two-col-form clearfix">
						<?php echo $form->input('discount_percentage', array('label' => __l('Discount (%)')));  ?>
						<span class="sep-or"><?php echo __l('OR'); ?></span>
						<?php echo $form->input('discount_amount', array('label' => __l('Discount Amount'), $currecncy_place => Configure::read('site.currency'))); ?>
					</div>
					<?php echo $form->input('savings', array('type'=>'text',  'label' => __l('Savings for user'),  'readonly' => 'readonly', $currecncy_place => Configure::read('site.currency')));
					echo $form->input('discounted_price', array('label' => __l('Discounted price for user'),'type'=>'text', 'readonly' => 'readonly', $currecncy_place => Configure::read('site.currency')));
				?>
				<div class="page-info">
				<?php
					echo __l('When you want to add as a free deal, just give 100% discount for this deal');
				 ?>
			     </div>
			</fieldset>


			
		   <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Commission'); ?></legend>
			 <div class="page-info">
				<?php
					echo __l('Total Commission Amount = Bonus Amount + ((Discounted Price * Number of Buyers) * Commission Percentage/100))');
				 ?>
			</div>
			<div class="clearfix">
			<div class="amount-block commision-form-block">
			<?php
			echo $form->input('bonus_amount', array('label' => __l('Bonus Amount'),'value' => '0.00',$currecncy_place => Configure::read('site.currency'), 'info' => __l('This is the flat fee that the company will pay for the whole deal.')));
			echo $form->input('commission_percentage', array('info' => __l('This is the commission that company will pay for the whole deal in percentage.'), 'label' => __l('Commission (%)')));
			if($auth->user('user_type_id') == ConstUserTypes::Admin):
				echo $form->input('private_note', array('type' =>'textarea', 'label' => __l('Private Note'), 'info' => __l('This is for admin reference. It will not be displayed for other users.')));
			endif;
			?>
			</div>
			<div class="calculator-block round-5">
				<?php echo $this->element('../deals/commission_calculator', array('cache' => array('time' => Configure::read('site.element_cache'), 'key' => $auth->user('id')))); ?>
			</div>
			</div>
			<?php
				echo $form->input('description', array('label' => __l('Description'),'type' =>'textarea', 'class' => ''));
			?>
		</div>
	   <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Deal Image'); ?></legend>
			<div class="required">
			<div class="input required gig-img-label">
					<label><?php echo __l('Deal Images');?></label>
			
				<?php
					$redirect_check = (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') ? "true" : "false";
					if($auth->user('user_type_id') == ConstUserTypes::Admin):
						$redirect_array = array('controller' => 'deals', 'action' => 'index', 'type' => 'success','admin' => true);
					else:
						$redirect_array = array('controller' => 'deals', 'action' => 'company', $this->data['Deal']['company_slug'], 'success','admin' => false);
					endif;
					echo $form->uploader('Attachment.filename', array('type'=>'file', 'uController' => 'deals', 'uRedirectURL' => $redirect_array, 'uId' => 'dealID', 'uFiletype' => Configure::read('photo.file.allowedExt')));
				?>
		
				</div>
				<?php
				 if(!empty($this->data['CloneAttachment'][0])) {?>
	<div class="attachment-delete-block">
					  <span class="delete-photo"> <?php echo __l('Delete Photo'); ?></span>

					<?php
						
                	$i =0;
                	foreach($this->data['CloneAttachment'] as $CloneAttachment){
                    echo $form->input('OldAttachment.'.$CloneAttachment['id'].'.id', array('type' => 'checkbox', 'class'=>'','id' => "gig_checkbox_".$attachment['id'], 'label' => false));
                    echo $form->input('CloneAttachment.'.$i.'.id', array('type' => 'hidden', 'value' => $CloneAttachment['id']));
					echo $html->showImage('Deal', $CloneAttachment, array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($this->data['Deal']['name'], false)), 'title' => $html->cText($this->data['Deal']['name'], false)));
					$i++;
					}?>
					</div>
                <?php }	?>
			</div>
		</fieldset>
	   <fieldset class="form-block round-5">
        <legend class="round-5"><?php echo __l('Review'); ?></legend>
		<?php
			echo $form->input('review', array('label' => __l('Review'),'type' => 'textarea', 'class' => 'js-editor'));
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

	<div class="submit-block clearfix">
<?php
	echo $form->input('is_save_draft', array('type' => 'hidden', 'id' => 'js-save-draft'));
	echo $form->submit(__l('Add'), array('class' => 'js-update-order-field'));
	echo $form->submit(__l('Save as Draft'), array('name' => 'data[Deal][save_as_draft]', 'class' => 'js-update-order-field')); ?>

   </div>
    <div class="info-details"><?php echo __l('Save this deal as a draft and view the preview of the deal. You can make changes untill you send it to upcoming status. Use the update button in edit page to send it to upcoming status.'); ?></div>
<?php echo $form->end();
?>
</div>