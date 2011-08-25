<script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".slider<?php echo $ID; ?>").slideshow({
        width      : 608,
        height     : 320,
        transition : 'squareRandom'
      });
    });
  </script>
<div class="slider<?php echo $ID; ?>">
  <?php
  if(count($IMAGES)>0){
  	for($i=0;$i<count($IMAGES);$i++){
  ?>	
  <div>
  	<div class="slider-deal-example">
      	<?php
			echo $html->link($DEAL['name'], array('controller' => 'deals', 'action' => 'view', $DEAL['slug']),array('title' =>sprintf(__l('%s'),$DEAL['name'])));
		?>
    </div>
    <?php echo $html->showImage('Deal', $IMAGES[$i], array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($NAME, false)), 'title' => $html->cText($NAME, false)));?>
  </div>  
  <?php
  	}
  }else{
  ?>
  <div>
    <?php echo $html->showImage('Deal', $IMAGES[0], array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $html->cText($NAME, false)), 'title' => $html->cText($NAME, false)));?>
  </div>
  <?php
  }
  ?>  
</div>