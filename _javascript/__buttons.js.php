<script>
<?php

$buttons = array(
	'actNewLoad',
	'actNewProcess',
	'storeWindowOpen',
	'storeWindowClose',
	'fightCloseProcess',
	'fightVictoryClose',
	'mapUtilityOpen',
	'statsUtilityOpen',
	'bagUtilityOpen',
	
	'jobApplyProcess',
	'jobWorkStart',
	
	'gigApplyProcess',
	'pcUtilityOpen',
	'showJoinOpen',
	'showMyLoad',
	'showNewForm',
	
	'storeDataLoad',
	
	'worldLogoutProcess',
	'worldHomeLoad',
	'worldMessageClose',
	'worldSleepStart'
);

foreach ($buttons as $button){
	echo "$('.".$button."').live('click',function(){".$button."()});";
}

?>

$('.botTalkOpen').live('click',function(){botTalkOpen($(this).attr('bot_id'));})

$('.fightMethodSelect').live('click',function(){fightMethodSelect($(this).attr('software_id'),$(this).attr('skill_id'));})
$('.fightMethodUse').live('click',function(){	fightMethodUse($(this).attr('bug_id'));})

$('.itemBuyProcess').live('click',function(){itemBuyProcess($(this).attr('sitem_id'),$(this).attr('store'));})
$('.itemDestroyProcess').live('click',function(){itemDestroyProcess($(this).attr('item_user_id'));})
$('.itemSellProcess').live('click',function(){itemSellProcess($(this).attr('item_user_id'));})
$('.itemUseProcess').live('click',function(){itemUseProcess($(this).attr('item_id'));})
$('.itemEquipProcess').live('click',function(){itemEquipProcess($(this).attr('item_user_id'));})
$('.itemUnequipProcess').live('click',function(){itemUnequipProcess($(this).attr('item_user_id'));})

$('.skillBuyProcess').live('click',function(){skillBuyProcess($(this).attr('skill_id'),$(this).attr('store'));})

$('.softwareBuyProcess').live('click',function(){softwareBuyProcess($(this).attr('software_id'),$(this).attr('store'));})
$('.softwareUpgradeProcess').live('click',function(){softwareUpgradeProcess($(this).attr('software_id'));})

$('.storeSelectionShow').live('click',function(){storeSelectionShow($(this).attr('type'));})


$('.worldMoverProcess').live('click',function(){worldMoverProcess($(this).attr('d'));});
$('.worldToolsShow').live('click',function(){worldToolsShow($(this).attr('loctab'));});
$('.worldQuestClose').live('click',function(){$('.quest').remove();});
$('.worldItemPickup').live('click',function(){worldItemPickup($(this).attr('key'));});

$('.worldLootPickup').live('click',function(){worldLootPickup($(this).attr('key'));});

$('.worldMoneyPickup').live('click',function(){	worldMoneyPickup($(this).attr('key'));});
$('.worldTurnProcess').live('click',function(){worldTurnProcess($(this).attr('d'));});



</script>