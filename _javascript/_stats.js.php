<script>

function statsUtilityOpen() {
	
	$.post(siteUrl+'stats/ajax_statsUtilityOpen',function(data){
	
		
		$('#ram').html(data.ram);
		$('#max_ram').html(data.max_ram);
		$('#hp').html(data.hp);
		$('#max_battery').html(data.max_battery);
	

		$('#utility-contents').html(data.utility);
		document.utility = 'stats';
		
	},'json');
	
	
}
</script>