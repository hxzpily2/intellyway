<?php if($auth->user('user_type_id') == ConstUserTypes::Company):?>
   <?php echo $this->element('js_tiny_mce_setting', array('cache' => array('time' => Configure::read('site.element_cache'))));?>
<?php endif; ?>
<h2 class="login-title"><?php echo __l('My Stuff'); ?></h2>
<br/><br/>
<div class="js-mystuff-tabs">
    <ul class="clearfix">
        <?php if($auth->user('user_type_id') == ConstUserTypes::Company):?>    
        	<?php $user = $html->getCompany($auth->user('id')); ?>
            <li><?php echo $html->link(__l('My Account'), array('controller' => 'companies', 'action' => 'edit', $user['Company']['id']), array('title' => 'My Account', 'rel' => 'address:/' . __l('My_Account'))); ?></li>
        <?php else: ?>
            <li><?php echo $html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'my_account', $auth->user('id')), array('title' => 'My Account', 'rel' => 'address:/' . __l('My_Account'))); ?></li>
        <?php endif; ?>
        <?php if($auth->sessionValid() && $html->isAllowed($auth->user('user_type_id'))):?>
              <li><?php  echo $html->link(sprintf(__l('My %s'), Configure::read('site.name')), array('controller' => 'deal_users', 'action' => 'index'), array('title' => 'My Purchases', 'rel' => 'address:/' . __l('My_Purchases')));?></li>
              <li><?php echo $html->link(__l('My Gift Cards'), array('controller' => 'gift_users', 'action' => 'index', 'admin' => false), array('title' => 'My Gift Cards', 'rel' => 'address:/' . __l('My_Gift_Cards')));?></li>
              <li><?php echo $html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index', 'admin' => false), array('title' => 'My Transactions', 'rel' => 'address:/' . __l('My_Transactions')));?></li>
              <?php if(Configure::read('friend.is_enabled')): ?>
              <li><?php echo $html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst', 'admin' => false), array('title' => 'My Friends', 'rel' => 'address:/' . __l('My_Friends')));?></li>
               <li><?php echo $html->link(__l('Import Friends'), array('controller' => 'user_friends', 'action' => 'import', 'admin' => false), array('title' => 'Import Friends', 'rel' => 'address:/' . __l('Import_Friends'))); ?></li>
              <?php endif; ?>
        <?php endif; ?>
    </ul>
</div>