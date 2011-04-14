<script>

function gigApplyProcess() {
	
	$.post(siteUrl+'gig/ajax_gigApplyProcess',function(data){
		
			$('#gig').html(data.response);
			$('#message').css('display','block').html(data.thanks);
			
	},'json')

}

</script>