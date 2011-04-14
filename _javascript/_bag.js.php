<script>

function bagUtilityOpen(){

	bagItemsLoad()
	document.utility = 'bag';
}

function bagItemsLoad(){
	$.post(siteUrl+'bag/ajax_bagItemsLoad',function(data){
		$('#utility-contents').html(data);
	})
	
}

</script>