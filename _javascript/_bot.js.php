<script>

function botTalkOpen(bot_id) {

	$('.pickup, .quest, #rightLoc, #leftLoc').remove();
	
	$.post(siteUrl+'bot/ajax_botTalkOpen/'+bot_id,function(data){
	
		$('#bot-talk').html(data.response);
		$('#zname, #desc, #gig, #job, #store, #message').css('display','none');
		
		if (data.responseType=='fight'){
		
			document.allow_move = false;
			document.allow_turn = false;
		
		
			//$('#me').animate({'left':553,'top':-233},300);
		
		
			$('#skills').css('display','inline');

			for (key in data.bugs){
				fightTimeoutStart(data.bugs[key].sbug_id, data.bugs[key].cooldown);
			}
			
		}
		
		if (data.responseType=='gift'){
			

			
		}
		
		
		if (data.quest !== ''){
			$('#world').append(data.quest.html);
		}		
		
		
		$('span[bot_id="'+bot_id+'"]').remove();
		
		$('div[bot_id="'+bot_id+'"]').fadeOut('',function(){
			$('div[bot_id="'+bot_id+'"]').remove();
		});		
		
		if (data.demo !== ''){
			$('#world').append(data.demo);
		}		
	},'json')
	
	window.battles = new Array();
	document.cooldown = false;
}


function botFightWin() {

	$.post(siteUrl+'bot/ajax_botFightLoad/'+bot_id,function(data){
		
		$('div[bot_id="'+bot_id+'"]').fadeOut('',function(){
			$('div[bot_id="'+bot_id+'"]').remove();
		});
		
		$('#bot-reponse').html(data);
	});

}

</script>