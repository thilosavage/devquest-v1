<script>

function skillBuyProcess(skill_id){
	
	$.post(siteUrl+'skill/ajax_skillBuyProcess/'+skill_id,function(data){

		if (data.error == 1){
			worldMessageOpen('You dont have enough money to buy that');
		}
		else if (data.error == 2){
			worldMessageOpen('You can only own one of this book');
		}

		else {
			$('#money').html(data.money);
			
			if (document.utility == 'bag') {
				bagItemsLoad();
			}

			fightSkillsLoad();
			
			if (store==1) {
				storeDataLoad();
			}
			else {
				$('span[skill_id="'+skill_id+'"]').remove();
				$('div[skill_id="'+skill_id+'"]').fadeOut('',function(){
					$('div[skill_id="'+skill_id+'"]').remove();
				});			
			}		
		}

	},'json')	


}

</script>