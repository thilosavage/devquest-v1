<script>


function pcUtilityOpen() {

	$.post(siteUrl+'pc/ajax_pcUtilityOpen',function(data){
		
		$('#utility-contents').html(data);
		
	});

}

</script>