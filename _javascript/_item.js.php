<script>
function itemBuyProcess(sitem_id,store) {
	$.post(siteUrl+'item/ajax_itemBuyProcess/'+sitem_id+'?s='+store,function(data){
		if (data.error == 1){
			worldMessageOpen('You dont have enough money to buy that');
		}
		else if (data.error == 2) {
			worldMessageOpen('You can only have one of this item');
		}
		else if (data.error == 4) {
			worldMessageOpen('This item does not exist');
		}		
		else {
			$('#money').html(data.money);
			
			if (document.utility == 'bag') {
				bagItemsLoad();

			}
			
			if (store!==1) {
				//storeItemsLoad();

				//$('span[item_id="'+item_id+'"]').remove();
				//$('div[item_id="'+item_id+'"]').fadeOut('',function(){
				//	$('div[item_id="'+item_id+'"]').remove();
				//});			
			}
			if (data.max_hp){
				$('#max_hp').html(data.max_hp);
			}
			if (data.max_ram){
				$('#max_ram').html(data.max_ram);
			}
			
			if (data.cumulative !== "1") {
				
				$('div[sitem_id='+sitem_id+']').fadeOut();
			}
			
			
			
			
		}
	},'json')
}

function itemUseProcess(item_id){

	$.post(siteUrl+'item/ajax_itemUseProcess/'+item_id,function(data){
	
		if (data.cumulative) {
			$('#ram').html(data.updates.ram);
			
			meHpCalculate(data.hp_bar_width);
			
			bagItemsLoad();
		}
		else {
			$('tr[item_user_id='+item_user_id+']').fadeOut(100);
		}
		
	},'json');

}


function itemSellProcess(item_user_id){
	
	$.post(siteUrl+'item/ajax_itemSellProcess/'+item_user_id,function(data){
		
		if (data.error == 7) {
			worldMessageOpen('This item isnt yours.');
		}
		else {
			$('#money').html(data.money);
			

			if (data.cumulative) {
				bagItemsLoad();
			}
			else {
				$('tr[item_user_id='+item_user_id+']').fadeOut(100);
			}

		}

	},'json');

}

function itemEquipProcess(item_id) {

	$.post(siteUrl+'item/ajax_itemEquipProcess/'+item_id,function(data){
	
		if (data.error) {
			worldMessageOpen(data.error);
		}
		else {
			
			$('#max_hp').html(data.max_hp);
			$('#max_ram').html(data.max_ram);

			bagItemsLoad();
		}
		

		
	},'json')	

}

function itemUnequipProcess(item_id) {

	$.post(siteUrl+'item/ajax_itemUnequipProcess/'+item_id,function(data){
	
		if (data.error) {
			worldMessageOpen(data.error);
		}
		else {

			$('#max_hp').html(data.max_hp);
			$('#max_ram').html(data.max_ram);
			$('#hp').html(data.hp);
			$('#ram').html(data.ram);
			
			bagItemsLoad();
		}

	},'json')	

}

function itemDestroyProcess(item_user_id) {

	$.post(siteUrl+'item/ajax_itemDestroyProcess/'+item_user_id,function(data){
	
		if (data) {
			$('table[item_user_id='+item_user_id+']').remove();
		}
	
	});

}

</script>