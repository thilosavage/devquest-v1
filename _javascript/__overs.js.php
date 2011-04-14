<script>


$('.fightMethodSelect').live('mouseover',function(){
	$('#fight-tool-tip').html($(this).attr('desc'));
})

$('.fightMethodSelect').live('mouseout',function(){
	$('#fight-tool-tip').html('');
})


$(".itemDetailsOver").live('mouseover',function(){
	$(this).contents("span:last-child").css('display','block');
});

$(".itemDetailsOver").live('mouseout',function(){
	$(this).contents("span:last-child").css('display','none');
});


$("#fight-target").live('mouseover',function(){
	bugDetailsShow($(this).attr('name'));
});

$("#fight-target").live('mouseout',function(){
	$('#bug-details').remove();
});

</script>