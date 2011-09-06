<style type="text/css">
#map_canvas<?php echo $ID; ?>{
	width: 146px; height: 170px;
	border-style:solid;
	border-width:1px;
	color:#3399CC;
}

#map_canvas<?php echo $ID; ?> span{
	display:none;
}

</style>


<script type="text/javascript">

function initialize<?php echo $ID; ?>() {
  if (GBrowserIsCompatible()) { 	
 	
 	
	<?php
	$address=$COMPANY; 
	$gadresse = $address['address1'].', '.$address['address2'].', '.((!empty($address['City']['name'])) ? $address['City']['name'] . ', ' : '').', '.((!empty($address['State']['name'])) ? $address['State']['name'] . ', ' : '');
	
	?>
		
    var adresse = '<?php echo $gadresse; ?>';
	
	var geocoder = new google.maps.ClientGeocoder();
	
	geocoder.getLatLng(adresse, function (coord) {
       		var map = new GMap2(document.getElementById("map_canvas<?php echo $ID; ?>"));
            map.setCenter(coord, <?php echo $ZOOM; ?>);            
    		
            var myIcon = new GIcon(G_DEFAULT_ICON);
		    myIcon.image = "<?php echo $this->webroot; ?>img/my_custom_icon.png";
		    myIcon.iconSize = new GSize(22, 31);
		    myIcon.shadow = "<?php echo $this->webroot; ?>img/my_custom_icon_shadow.png";
		    myIcon.shadowSize = new GSize(42, 31);
		    myIcon.iconAnchor = new GPoint(10, 29);
		    myIcon.infoWindowAnchor = new GPoint(10, 14);
		    /*myIcon.printImage = "my_custom_icon_print.gif";
		    myIcon.mozPrintImage = "my_custom_icon_mozPrint.gif";
		    myIcon.printShadow = "my_custom_icon_printShadow.gif";*/
		    myIcon.transparent = "<?php echo $this->webroot; ?>img/my_custom_icon_transparent.png";
		    myIcon.imageMap = [ 10,29, 1,16, 0,5, 5,0, 12,4, 18,2, 21,12, 21,16 ]; 
		    
		    var markerOptions = { icon:myIcon };
		    
		    var marker = new GMarker(map.getCenter(), markerOptions);
		    GEvent.addListener(marker, "click", function () {
		      marker.openInfoWindowHtml("Hello");
		    });
		    map.addOverlay(marker);
    });
	  
    

    
  }
}


$(window).load(function() {
    initialize<?php echo $ID; ?>();
});

</script>

<div id="map_canvas<?php echo $ID; ?>"></div>
