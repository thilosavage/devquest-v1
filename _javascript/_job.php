<script>

function jobApplyProcess() {

	$.post(siteUrl+'job/ajax_jobApplyProcess',function(data){
		
		$('#job-window').html(data.response);
			
			
	},'json')

}

function jobWorkStart() {

	$.post(siteUrl+'job/ajax_jobWorkStart',function(data){

		$('#work-status').html(data.response);

	},'json')

}

</script>