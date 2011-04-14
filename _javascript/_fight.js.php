<script>

function fightMethodSelect(software_id, skill_id){
	
	//$('.weapon-cell').removeClass('method-selected').addClass('method-unselected');

	$('.software-selected').removeClass('software-selected').addClass('software-unselected');
	$('.skill-selected').removeClass('skill-selected').addClass('skill-unselected');
	
	
	if (isset(software_id)) {
		$('div[software_id='+software_id+']')
					.removeClass('software-unselected')
					.addClass('software-selected');		
		document.method = 'software';
		document.method_id = software_id;
		
	}
	else {
		$('div[skill_id='+skill_id+']')
					.removeClass('skill-unselected')
					.addClass('skill-selected');		
		document.method = 'skill';
		document.method_id = skill_id
	}
	
	document.method_cd = $('div['+document.method+'_id='+document.method_id+']').attr('cd');
	document.method_name = $('div['+document.method+'_id='+document.method_id+']').attr('name');
	document.ram = $('div['+document.method+'_id='+document.method_id+']').attr('ram');
	
	
}

function fightMethodUse(target_id){
	
	

	var fields = {
		method: document.method,
		method_id: document.method_id,
		method_cd: document.method_cd
	}

	var error = false;
	
	if (document.method == 'software'){
		var ram = $('div[software_id='+document.method_id+']').attr('ram');
		
		if (parseInt($('#ram').html()) < ram) {
		
			error = 'Not enough RAM!';
			
		}	
	}

	
	if (!error) {
		
		$('.quest').remove();
		
		$('#leave-fight').removeClass('fightCloseProcess fakelink').css('color','gray');
		
		if (isset(document.method) && isset(document.method_id) && document.cooldown == false){
		
			$("<div id='cooldown' style='z-index: 222; position: absolute; top: 393px; left: 0px; background-color: black; height: 158px; width: 758px;'></div>").appendTo('#world');
			$('#cooldown').css('opacity','.5');
			document.cooldown = true;
			
			var w = document.method_cd / 10;
			
			if (document.method == 'skill'){
				var waitMsg = 'Using '+document.method_name;
			}
			else if (document.method == 'software'){
				var waitMsg = 'Installing '+document.method_name;
			}
			
			$('#cooldown').after("<div id='cooldownbar' style='z-index: 223; position: absolute; top: 443px; left: 297px; background-color: red; height: 27px; width:300px;'>"+waitMsg+"</div>");

			$('#cooldownbar').animate({'width':'0'},parseInt(document.method_cd));	
		
			userAttack = setTimeout(function(){

				$.post(siteUrl+'fight/ajax_fightMethodUse/'+target_id,fields,function(data){
					
					
					
					// bug hp bar
					var curWidth = $('div[bug_id='+data.bugs.sbug_id+'] .bug_hp').width();
					var dam =  data.damage / data.bugs.hp;
					var ddam = curWidth - Math.floor(dam * 100);
					$('div[bug_id='+data.bugs.sbug_id+'] .bug_hp').animate({'width':ddam},200);

					
					
					
					
					
					
					
					
					
					
					// ram bar
					$('#ram').html(data.ram);

					
					hudHpCalculate(data.hp_bar_width);
					hudRamCalculate(data.ram_bar_width);
					
					var curWidth = $('div[bug_id='+data.bugs.sbug_id+'] .bug_hp').width();
					var dam =  data.damage / data.bugs.hp;
					var ddam = curWidth - Math.floor(dam * 100);
					$('div[bug_id='+data.bugs.sbug_id+'] .bug_hp').animate({'width':ddam},200);					
					
					
					
					
					
					
					
					
					
					
					
					
					$('div[bug_id='+data.bugs.sbug_id+']').append("<div id='bughit"+data.bugs.sbug_id+"' style='position: absolute; top: -15px; left: 15px; font-size: 36px; color: red'>"+data.damage+"</div>");
					$('#bughit'+data.bugs.sbug_id).animate({'top':'-20'},300,function(){
						$('#bughit'+data.bugs.sbug_id).remove();
					});
				
					

					if (data.bugs.hp_left == 'dead'){
					
						
						if (data.quest !== ''){
							$('#world').append(data.quest.html);
						}
						
						
						clearTimeout(window.battles[data.bugs.bug_id]);  
						
						
						$('div[bug_id='+data.bugs.sbug_id+']').removeClass('fightMethodUse').fadeOut('200');
						if (data.clear == 1){
						
						
						
						
							console.log(data.level);
							
							
						
							hudExpCalculate(data.exp_bar_width);
						
						
							for (key in window.battles){  
								clearTimeout(window.battles[key]);  
							}					
							$('div[bot_id='+data.bot.bot_id+']').remove();
							
							if (document.utility == 'stats') {
								statsUtilityOpen();
							}

							$('#skills').css('display','none');
							
							//$('#action').append("<div style='position: absolute; top: 20px; left: 140px; z-index: 1000;' id='bugs-clear'>"+data.results+"</div>");
							$('#bugs').html(data.results);
							
							if (data.loot) {
								
								for ( var i in data.loot ) {

									var leftloot = 20 + Math.floor(Math.random()*500);
									var lootimg = "<img width='80' src='"+siteUrl+"_images/items/"+data.loot[i].item_id+".png'>";

									$('#world').append("<span class='world-loot worldLootPickup fakelink' key='"+data.loot[i].key+"' style='left: "+leftloot+"'>"+lootimg+"</span>");

								}

								$('#upLoc').remove();
								
							}
							if (data.cash) {
								var leftloot = 20 + Math.floor(Math.random()*500);
								
								$('#world').append("<div class='world-loot' style='left: "+ leftloot+"'>"+data.cash+"</div>");
								$('#upLoc').remove();			
								
							}

							
							// hud
							$('#level').html(data.level);
							$('#exp').html(data.exp);
							$('#energy').html(data.energy);
							$('#money').html(data.money);

						}
						else {
							$('#fight-tool-tip').html(data.response);
						}
					}
					else {

						$('div[bug_id='+data.bugs.sbug_id+']').children('span').children('#bug-hp_left').html(data.bugs.hp_left);
						
						$('#fight-tool-tip').html(data.response);

					}
					$('#cooldown').remove();
					$('#cooldownbar').remove();
					document.cooldown = false;
					$('#leave-fight').addClass('fightCloseProcess fakelink').css('color','black');
					
				},'json')	
			
			},parseInt(document.method_cd));
			
		}
		else {
			$('#fight-tool-tip').html('Please select a method of attack');
		}
		$('#fight-error').remove();
	}
	else {
		fightMessage(error);
	}
}

function fightMessage(message){

		$('#fight-error').remove();
		$('#bugs').append("<div id='fight-error' style='position: absolute; top: 200px; left: 100px; background-color: black; color: red; font-size: 18px; padding: 5px;'>"+message+"</div>");
		
}

function fightVictoryClose(){

	$('#me').animate({'left':0,'top':0},300);
	$('#bugs-clear').remove();
	
		
}


function fightBugAttack(bug_id){
	
	$.post(siteUrl+'fight/ajax_fightBugAttack/'+bug_id,function(data){

		posLeft = 35 + data.rPos;

		$('#hp_left').html(data.hp_left);
		$('#hp').html(data.hp_left);
		
		$('div[bug_id='+bug_id+']').css('border','solid 2px red');
		$('div[bug_id='+bug_id+']').animate({'top': '+=5px'},100,'',function(){
			$('div[bug_id='+bug_id+']').animate({'top': '-=5px'},100);
			$('div[bug_id='+bug_id+']').css('border','');
		});
		

		hudHpCalculate(data.hp_bar_width);
		

	
		
		if (data.damage == '0'){
			var damage = '<span style="font-size: 14px">miss</span>'
		}
		else {
			var damage = data.damage;
		}
		
		$('div[bot_id=me]').append("<div id='userhit"+bug_id+"' style='position: absolute; top: -22px; left: "+posLeft+"px; font-size: 36px; color: red; z-index: 40;'>"+damage+"</div>");
		$('#userhit'+bug_id).animate({'top':'-=20','opacity':0},300,function(){
			$('#userhit'+bug_id).remove();
		});
		
		if (data.dead == 1){
		
			document.dead = 1;
			
			$('#hp_left').html('0');
			$('#hp').html('0');		
			for (key in window.battles){  
				clearTimeout(window.battles[key]);  
			}
			
			clearTimeout(userAttack);
			
			$("<div id='cooldown' style='z-index: 222; position: absolute; top: 393px; left: 0px; background-color: black; height: 158px; width: 758px;'>").appendTo('#world');
			$('#cooldown').css('opacity','.5');		
			$('#bot-talk-content').html(data.results);
			$('#status').html('');
			$('#bugs').remove();
			
			$('#bot-talk-content').css('background-color','red');
			
			$('#cooldownbar').remove();
			$('#cooldown').remove();
			
			
			$('#leave-fight').addClass('fightCloseProcess fakelink').css('color','black').html('Go home');
			
		}

	},'json')

}

function fightTimeoutStart(bug_id,cooldown){

	var tName = 'attack'+bug_id;
	var timeOuts = new Array(); 
	
	clearTimeout(window.battles[bug_id]);
	
	window.battles[bug_id] = setTimeout(function(){
		
		fightBugAttack(bug_id);
		fightTimeoutStart(bug_id, cooldown);
		
	},parseInt(cooldown));


}

function fightCloseProcess(){
	
	$('.quest').remove();
	
	document.allow_move = true;
	document.allow_turn = true;
	
	if (document.dead == 1) {
		worldReviveProcess();
	}
	fightVictoryClose();
	
	$('#skills').css('display','none');
	$('#bot-talk').html('');
	$('#zname, #desc, #gig, #job, #store').css('display','');
	
	$('.demo').remove();
	
	for (key in window.battles){  
		clearTimeout(window.battles[key]);  
	}  
}


function fightSkillsLoad() {

	$.post(siteUrl+'fight/ajax_fightSkillsLoad',function(data){
		
		$('#skills').html(data);
	
	})

}

</script>