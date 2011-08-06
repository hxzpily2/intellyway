<style type="text/css">

</style>

<script type="text/javascript">

year<?php echo $ID; ?> = 2011; month<?php echo $ID; ?> = 8; day<?php echo $ID; ?> = 24;
hour<?php echo $ID; ?>= 16; min<?php echo $ID; ?>= 0; sec<?php echo $ID; ?>= 0;

month<?php echo $ID; ?>= --month<?php echo $ID; ?>;
dateFuture<?php echo $ID; ?> = new Date(year<?php echo $ID; ?>,month<?php echo $ID; ?>,day<?php echo $ID; ?>,hour<?php echo $ID; ?>,min<?php echo $ID; ?>,sec<?php echo $ID; ?>);

function GetCount<?php echo $ID; ?>(){		
        dateNow<?php echo $ID; ?> = new Date();                                                            
        amount<?php echo $ID; ?> = dateFuture<?php echo $ID; ?>.getTime() - dateNow<?php echo $ID; ?>.getTime()+5;               
        delete dateNow<?php echo $ID; ?>;

        // time is already past
        if(amount<?php echo $ID; ?> < 0){
                out<?php echo $ID; ?>=
				"<div class='days'><span></span>0<div class='days_text'><?php echo __l('Days'); ?></div></div>" + 
				"<div class='hours'><span></span>0<div class='hours_text'><?php echo __l('Hours'); ?></div></div>" + 
				"<div class='mins'><span></span>0<div class='mins_text'><?php echo __l('Minutes'); ?></div></div>" + 
				"<div class='secs'><span></span>0<div class='secs_text'><?php echo __l('Seconds'); ?></div></div>" ;
                document.getElementById('countbox<?php echo $ID; ?>').innerHTML=out<?php echo $ID; ?>;       
        }
        // date is still good
        else{
                days<?php echo $ID; ?>=0;hours<?php echo $ID; ?>=0;mins<?php echo $ID; ?>=0;secs<?php echo $ID; ?>=0;out<?php echo $ID; ?>="";

                amount<?php echo $ID; ?> = Math.floor(amount<?php echo $ID; ?>/1000);//kill the "milliseconds" so just secs

                days<?php echo $ID; ?>=Math.floor(amount<?php echo $ID; ?>/86400);//days
                amount<?php echo $ID; ?>=amount<?php echo $ID; ?>%86400;

                hours<?php echo $ID; ?>=Math.floor(amount<?php echo $ID; ?>/3600);//hours
                amount<?php echo $ID; ?>=amount<?php echo $ID; ?>%3600;

                mins<?php echo $ID; ?>=Math.floor(amount<?php echo $ID; ?>/60);//minutes
                amount<?php echo $ID; ?>=amount<?php echo $ID; ?>%60;

                
                secs<?php echo $ID; ?>=Math.floor(amount<?php echo $ID; ?>);//seconds


                out<?php echo $ID; ?>=
				"<div class='days'><span></span>" + days<?php echo $ID; ?> +"<div class='days_text'><?php echo __l('Days'); ?></div></div>" + 
				"<div class='hours'><span></span>" + hours<?php echo $ID; ?> +"<div class='hours_text'><?php echo __l('Hours'); ?></div></div>" + 
				"<div class='mins'><span></span>" + mins<?php echo $ID; ?> +"<div class='mins_text'><?php echo __l('Minutes'); ?></div></div>" + 
				"<div class='secs'><span></span>" + secs<?php echo $ID; ?> +"<div class='secs_text'><?php echo __l('Seconds'); ?></div></div>" ;
                document.getElementById('countbox<?php echo $ID; ?>').innerHTML=out<?php echo $ID; ?>;
			

                setTimeout("GetCount<?php echo $ID; ?>()", 1000);
        }
}

$(window).load(function() {
      GetCount<?php echo $ID; ?>();
});


$(document).ready(function() {
    $('#countdown<?php echo $ID; ?>').counter(<?php echo $ID; ?>);
});

</script>

<div id="countdown<?php echo $ID; ?>" class="countdown"></div>

