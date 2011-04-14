<script>

function mapUtilityOpen() {
	$.post(siteUrl+'map/ajax_mapUtilityOpen',function(data){
		$('#utility-contents').html(data);
		
		mapHereSet(document.loc_id,document.bearing);
	});
	
	document.utility = 'map';
	
}

function mapHereSet(loc_id,bearing){
	
	
	
	$('#map-bearing').remove();
	$('#map-arrow').remove();
	$('.map-loc').css('background-color','white');
	$('.map-loc[loc_id='+loc_id+']').css('background-color','yellow');

	$('.map-loc[loc_id='+loc_id+']').append("<img id='map-arrow' src='"+siteUrl+"_images/map/"+bearing+".png'>");
	
	//alert($('.map-loc[loc_id='+loc_id+']').html());
	
	//alert(loc_id+'--'+bearing);
	
}

</script>