<script>

function worldToolsShow(tab){

	$('.loc-tab').css('display','none');
	$('#tools-'+tab).css('display','inline');
	
}

function worldMoverProcess(){
	
	if (document.allow_move) {
	
		$('.pickup, #loot, #rightLoc, #leftLoc, #upLoc, .quest, .world-loot').remove();

		var dir = document.bearing;
		
		document.allow_move = false;
		
		
		
		
		$('#mover-forward').removeClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/moving.png'>");
		
		$.post(siteUrl+'world/ajax_worldMoverProcess/'+dir,function(data){
		
			document.loc_id = data.newLoc.loc_id;
			
			$('#mover-load').html(loader);
			
			if (data.quest.tutorial_image) {
				var newBg = data.newLoc.loc_id+document.bearing+'T';
			}
			else {
				var newBg = data.newLoc.loc_id+document.bearing;
			}
			
			$('#background').attr('src',siteUrl+'_images/locs/'+newBg+'.jpg');
		
			if (data.deadEnd){
				worldMessageOpen('You cannot go beyond this point until you are at least level '+data.deadEnd);
			}
			
			if (data.rightLoc) {
				$('#loc').append("<div id='rightLoc' class='go-right-arrow fakelink worldTurnProcess' d='r'><img src='"+siteUrl+"_images/arrow-r.png'></div>");
			}
			if (data.leftLoc) {
				$('#loc').append("<div id='leftLoc' class='go-left-arrow fakelink worldTurnProcess' d='l'><img src='"+siteUrl+"_images/arrow-l.png'></div>");
			}
			
			if (document.utility == 'map'){
				mapHereSet(data.newLoc.loc_id,document.bearing);
			}
			
			if (data.artifacts) {
				$('#world').append(data.artifacts);
			}
			
			
			// action
			$('#zname').html(data.name);
			$('#desc').html(data.newLoc.desc);
			$('#gig').html(data.gig);
			$('#job').html(data.job);
			$('#store').html(data.store);
			
			
			if (data.reloadBag && document.utility == 'bag') {
				bagItemsLoad();
			}
			
			// hud
			$('#energy').html(data.energy);
			//$('#money').html(data.money);
			//$('#exp').html(data.exp);


			// bots
			$('#bots').html(data.bots);
			$('#bot-talk').html('');
			
			if (data.message.length>1) {
				$('#message').css('display','block').html(data.message);
			}
			else {
				$('#message').css('display','').html('');
			}
			
			
			if (data.quest !== ''){
				$('#world').append(data.quest.html);
			}
			
			setTimeout(function(){
			
				if (data.nextLoc && !data.deadEnd) {
					document.allow_move = true;
					$('#mover-forward').addClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/move.png'>");
					
					
					$('#loc').append("<div id='upLoc' class='go-up-arrow fakelink worldMoverProcess' d='n'><img src='"+siteUrl+"_images/arrow-u.png'></div>");
					
				}
				else {
					$('#mover-forward').removeClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/move_blur.png'>");
				}
				
			},10);
		},'json');
	}
}


function worldTurnProcess(d){

	if (document.allow_turn) {
		
		$('.pickup, #rightLoc, #leftLoc, #upLoc, .quest, .world-loot').remove();
		$('#gig').html('');
		
		document.allow_move = false;
		
		var fields = {
			'dir': d,
			'bearing': document.bearing
			};

		$('#mover-forward').removeClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/moving.png'>");
		
		$('#error-message').remove();
			
		$.post(siteUrl+'world/ajax_worldTurnProcess/',fields,function(data){
		
			if (data.artifacts) {
			
				$('#world').append(data.artifacts);

			}

			if (data.quest !== ''){
				$('#world').append(data.quest.html);
			}
			
			if (data.deadEnd){
				worldMessageOpen('You cannot go beyond this point until you are at least level '+data.deadEnd);
			}

		
			if (data.nextLoc && !data.deadEnd) {
				document.allow_move = true;
				$('#mover-forward').addClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/move.png'>");
				$('#loc').append("<div id='upLoc' class='go-up-arrow fakelink worldMoverProcess' d='n'><img src='"+siteUrl+"_images/arrow-u.png'></div>");
			}
			else {
		
				$('#mover-forward').removeClass('fakelink worldMoverProcess').html("<img src='"+siteUrl+"_images/hud/move_blur.png'>");
			}
			
			//$('#loc').css('background','url('+siteUrl+'_images/locs/'+document.loc_id+data.bearing+'.jpg)');
			
			if (d=='r') {
				//$('#bg').animate({left:'+=-720'},400);
			}
			else if (d=='l'){

				//$('#bg').animate({left:'+=720'},400);
			}
			
			
			document.bearing = data.bearing;
			
			$('#store').html(data.store);

			
			if (data.quest.tutorial_image) {
				var newBg = data.loc_id+document.bearing+'T';
			}
			else {
				var newBg = data.loc_id+document.bearing;
			}
			
			$('#background').attr('src',siteUrl+'_images/locs/'+newBg+'.jpg');
			
			

			if (document.utility == 'map'){
				mapHereSet(document.loc_id,data.bearing);
			}		
			if (data.reloadBag && document.utility == 'bag') {
				bagItemsLoad();
			}
			
			

		},'json');
	}
}



function worldLogoutProcess(){
	
	FB.logout(function(response) {
		location.href = siteUrl+'world/logout';
	});
}

function worldLoginProcess(action){
	//$.post(siteUrl+'login/ajax_process/'+redirect,function(data){
	if (action == 'redirect'){
		location.href = siteUrl+'world';
	}
}

function worldSleepStart(){

	$.post(siteUrl+'world/ajax_worldSleepStart',function(data){
	
		$('#ram').html(data.ram);
		$('#energy').html(data.energy);
		$('#hp').html(data.hp);
		
		
		
	},'json');
	
	//$('.me_hp').css('width','138');

}

function worldReviveProcess(){
	
	document.dead = 0;
	
	//$('.me_hp').css('width','138');
	
	$('#cooldown, .pickup, .world-loot').remove();

	document.bearing = '<?php echo settings::initial_bearing; ?>';
	document.loc_id = <?php echo settings::initial_home; ?>;
	
	$.post(siteUrl+'world/ajax_worldReviveProcess/'+document.loc_id,function(data){
	
		//$('#loc').css('background','url('+siteUrl+'_images/locs/'+data.loc.loc_id+document.bearing+'.jpg)');
		
		if (data.quest !== ''){
			$('#world').append(data.quest);
		}
		
		//$('#background-l').attr('src',siteUrl+'_images/locs/'+data.loc.loc_id+document.bearing+'.jpg');
		$('#background').attr('src',siteUrl+'_images/locs/'+data.loc.loc_id+document.bearing+'.jpg');
		//$('#background-r').attr('src',siteUrl+'_images/locs/'+data.loc.loc_id+document.bearing+'.jpg');
		
		// action
		$('#zname').html(data.name);
		$('#desc').html(data.loc.desc);
		
		// hud
		$('#energy').html(data.energy);
		
		//$('#hp').html(data.hp);
		$('.me_hp').css('width',data.hp_bar_width);
		
		
		$('#money').html(data.money);

		//$('#money').html(data.money);
		//$('#exp').html(data.exp);

		// bots
		$('#bots').html('');
		$('#bot-talk').html('');
		
		$('#gig').html('');
		$('#job').html('');
		$('#store').html('');		
		
		if (document.utility == 'map'){
			mapHereSet(document.loc_id,document.bearing);
		}
		
		$('#message').css('display','block').html(data.message);
		
		//worldMoverClear();
		
		
	},'json');
	
}


function worldItemPickup(key){
	$.post(siteUrl+'world/ajax_worldItemPickup/'+key,function(data){
	
	
		//if (data.error == 2) {
		//	worldMessageOpen('You can only have one of this item');
		//}
		if (data.error == 99) {
			worldMessageOpen('An error occured. Sorry.');
		}		
		else {
			//$('span[key='+data.key+']').removeClass('worldItemPickup').fadeOut(200,function(){

			$('span[key='+data.key+']').removeClass('worldItemPickup').children('img').attr('src',siteUrl+'_images/freebox-open.png');

			if (document.utility == 'bag') {
				bagItemsLoad();
			}		
		}
	

		
	},'json');
}

function worldLootPickup(key){
	$.post(siteUrl+'world/ajax_worldLootPickup/'+key,function(data){
	
		if (data.error == 99) {
			worldMessageOpen('An error occured. Sorry.');
		}		
		else {

			$('span[key='+data.key+']').removeClass('worldLootPickup, fakelink').remove();

			if (document.utility == 'bag') {
				bagItemsLoad();
			}		
		}
	

		
	},'json');
}

function worldMoneyPickup(key){

	$.post(siteUrl+'world/ajax_worldMoneyPickup/'+key,function(data){
	
		$('#money').html(data.newMoney);

		var left = $('span[key='+data.key+']').css('left');
		var top = $('span[key='+data.key+']').css('top') + 40;
	
		$('span[key='+data.key+']').append("<div id='artifact"+data.key+"' style='position: absolute; top: "+top+"; left: "+left+"; font-size: 36px; color: green'>"+data.money+"</div>");
		
		$('span[key='+data.key+']').removeClass('worldMoneyPickup, fakelink').remove();		
		
		$('#artifact'+data.key).animate({'top':'+=-10'},300,function(){
			$('#artifact'+data.key).remove();
		});
		
		

	},'json');
}

function worldMessageOpen(message){

		$('#error-message').remove();
		
		var mess = "<div id='error-message' style='position: absolute; top: 200px; left: 100px; z-index: 500; background-color: black; color: red; font-size: 22px; padding: 25px;'>";
		mess = mess + message;
		mess = mess + "<div class='fakelink worldMessageClose' style='text-align: right;'>Close</span>";
		mess = mess + "</div>";
		
		$('#world').append(mess);
		
}

function worldMessageClose(){
	$('#error-message').remove();
}


function worldZombifyProcess(){



	setTimeout(function(){
	
	
	
		//var me_hp_bar = $('#me_hp_bar').html();
		
		//$('#world').append("<div id='me_hp_bar'>"+me_hp_bar+"</div>");
		
		//$('#me_hp_bar').animate({'width':700},300);
		
		//$('#me').remove();
		
		$('#bg').append("<img style='position: absolute;' src='<?php echo site::url;?>_images/zombify-loc.png'>");
		
		//$('#panel').css('top',
	
	
	},500);
}

</script>