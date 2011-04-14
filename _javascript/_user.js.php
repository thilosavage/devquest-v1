<script>

function userStatsLoad(){

	$.post(siteUrl+'user/ajax_userStatsLoad',function(data){
	
		alert(data.response);
	
	},'json')

}

</script>