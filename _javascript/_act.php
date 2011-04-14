<script>
function actNewLoad(){
	$.post(siteUrl+'act/ajax_actNewLoad',function(data){
		$('#action').html(data);
	})
}
function actNewProcess(){

	var fields = {
		'name':$('#bandName').val(),
		'genre':$('#genre').val()
	}
	
	$.post(siteUrl+'act/ajax_actNewProcess',fields,function(data){
		$('#action').html(data.action);
		$('#history').prepend(data.history);
	},'json');
}

</script>