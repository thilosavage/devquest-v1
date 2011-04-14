<script>


function softwareBuyProcess(software_id) {
	$.post(siteUrl+'software/ajax_softwareBuyProcess/'+software_id,function(data){
		if (data.error == 1){
			worldMessageOpen('You dont have enough money to buy that');
		}
		else if (data.error == 2){
			worldMessageOpen('You already own this software');
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
			
				$('span[software_id="'+software_id+'"]').remove();
				$('div[software_id="'+software_id+'"]').fadeOut('',function(){
					$('div[software_id="'+software_id+'"]').remove();
				});			
			}			
		}

	},'json')
}

function softwareUpgradeProcess(software_id) {
	$.post(siteUrl+'software/ajax_softwareUpgradeProcess/'+software_id,function(data){
	
		if (data.error == 1){
			worldMessageOpen('You dont have enough money to upgrade that');
		}
		else if (data.error == 3){
			worldMessageOpen('You need to already own this software to upgrade it.');
		}
		else {

			$('#money').html(data.money);
			
			if (document.utility == 'bag') {
				bagItemsLoad();
			}
			
			fightSkillsLoad();
			storeDataLoad();		
		}
	},'json')
}


</script>