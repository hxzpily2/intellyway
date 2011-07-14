    <h2>Coupon</h2>
    
    <?php 
       $expire = strtotime($dealUserCoupon['DealUser']['Deal']['coupon_expiry_date']);
       $today = strtotime(date('Y-m-d H:i:s'));
       if($today>$expire): ?>
  
       <h3 class="coupon-expired">This coupon has been expired</h3>
  
    <?php endif; ?>
    <?php if(!empty($dealUserCoupon['DealUserCoupon']['is_used'])): ?>
        <h3 class="coupon-used">This coupon has been used</h3>
    <?php endif; ?>
   <div class="clearfix">
	  <table width='100%' cellpadding="5" cellspacing="3" border="0" class="list coupon-expired">
           <tr>
            <th ><?php echo __l('Deal name:')?></th>
            <td ><?php echo $html->cText($dealUserCoupon['DealUser']['Deal']['name']);?></td>
          </tr>
		  <tr>
            <th ><?php echo __l('Coupon code:'); ?></th>
            <td ><?php echo $html->cText($dealUserCoupon['DealUserCoupon']['coupon_code']);?></td>
          </tr>		  
          <tr>
            <th ><?php echo __l('Recipient:')?></th>
            <td ><?php echo $html->cText($dealUserCoupon['DealUser']['User']['username']);?></td>
          </tr>
          <tr>
            <th ><?php echo __l('Purchased:')?></th>
            <td ><?php echo $html->cDateTime($dealUserCoupon['DealUser']['created']);?></td>
          </tr>
          <tr>
            <th ><?php echo __l('Expires:')?></th>
            <td ><?php echo $html->cDateTime($dealUserCoupon['DealUser']['Deal']['coupon_expiry_date']);?></td>
          </tr>
          <?php if(!empty($dealUserCoupon['DealUserCoupon']['is_used'])): ?>
          <tr>
            <th ><?php echo __l('Used on:')?></th>
            <td ><?php echo $html->cDateTime($dealUserCoupon['DealUserCoupon']['modified']);?></td>
          </tr>
          <?php endif; ?>		 
        </table>
    
		<div class="coupon-expired-left">
	      <?php
		      $barcode_width = Configure::read('barcode.width');
			  $barcode_height = Configure::read('barcode.height');
              $parsed_url = parse_url($html->url('/', true));
              $qr_mobile_site_url = str_ireplace($parsed_url['host'], 'm.' . $parsed_url['host'], Router::url(array(
								'controller' => 'deal_user_coupons',
								'action' => 'check_qr',
								$dealUserCoupon['DealUserCoupon']['coupon_code'],
								$dealUserCoupon['DealUserCoupon']['unique_coupon_code'],
								'admin' => false
							) , true));
                            
		  ?>
		  <img src="http://chart.apis.google.com/chart?cht=qr&chs=<?php echo $barcode_width; ?>x<?php echo $barcode_height; ?>&chl=<?php echo $qr_mobile_site_url ?>" alt = "[Image: Deal qr code]"/>
		<p>
		  <?php echo $dealUserCoupon['DealUserCoupon']['unique_coupon_code'] ?>
		  </p>
		  </div>
		  </div>
	<div class="clearfix">
	   <?php
	      if(empty($dealUserCoupon['DealUserCoupon']['is_used'])):
			   echo $form->create('DealUserCoupon', array('controller'=>'deal_user_coupons', 'action'=> 'check_qr', 'class' => 'normal clearfix'));			  
			   echo $form->input('coupon_code', array('type'=>'hidden'));
			   echo $form->input('unique_coupon_code', array('type'=>'hidden'));
			   echo $form->submit(__l('Mark as Used'));
			   echo $form->end();            
		  endif;
	   ?>
</div>

