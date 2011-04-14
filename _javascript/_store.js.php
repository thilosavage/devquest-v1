<script>

function storeDataLoad(){
	
	$('.pickup, .quest').remove();
	
	$.post(siteUrl+'store/ajax_storeDataLoad',function(data){
		$('#store-window').html(data);
		
		if (document.utility == 'bag'){
			bagItemsLoad();
		}
	})

}

function storeSelectionShow(type) {

	$('#store-items').css('display','none');
	$('#store-software').css('display','none');
	$('#store-skills').css('display','none');
	
	$('#store-'+type).css('display','inline');
	

}

//function storeItemsLoad(){
	//$.post(siteUrl+'store/ajax_storeDataLoad',function(data){
		//$('#store-window').html(data);
	//})
//}



</script>