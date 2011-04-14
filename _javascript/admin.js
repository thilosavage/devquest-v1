<?php
$jsFolder = '_javascript/';
$jsFile = 'admin.js';

$jsPath = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
$docRoot = str_replace($jsFolder.$jsFile,'',$jsPath);
echo "//"; // comment out errors returned by the config

require_once($docRoot.'config.php');
require_once($docRoot.'Application/settings.php');
?>

var siteUrl = '<?php echo site::url;?>';
var loader = '<img src="<?php echo site::url;?>_images/loader.gif">';
function isset(variable){
	return (typeof(variable) == 'undefined')?false:true;
}


$('.locEditOpen').live('click',function(){
	
	loc_id = $(this).attr('loc_id');

	vx = $(this).attr('x');
	vy = $(this).attr('y');

	$('#zEditor').remove();
	
	var p = $('td[x|='+vx+']td[y|='+vy+']').position();
	
	var left = p.left - 7;
	var top = p.top - 7;

	var fields = {
		'loc_id':loc_id,
		'x':vx,
		'y':vy
	}
	
	$.post('<?php echo site::url;?>admin/ajax_locEditOpen',fields,function(data){

		$('body').append("<div id='zEditor' style='width: 230px; height: 200px; background-color: white; border: 1px solid black; position: absolute; top: "+top+"; left: "+left+"'>"+data+"</div>");	
	
	})
	
})

$('.locEditProcess').live('click',function(){
	

	var fields = {
		name: $('#loc[name]').val(),
		type: $('#locType').val(),
		loc_id: $('#loc_id').val(),
		x: $('#locX').val(),
		y: $('#locY').val()
	}

	
	$.post('<?php echo site::url;?>admin/ajax_locEditProcess',fields,function(data){
		
		$('td[x|='+data.x+']td[y|='+data.y+']').attr('loc_id',data.loc_id);
	
		$('td[x|='+data.x+']td[y|='+data.y+']').html('<div>'+data.name.substr(0,8)+'<br>'+data.loc_id+'</div>');
	
	},'json')

	$('#zEditor').remove();

})

$('.locDeleteProcess').live('click',function(){
	
	var fields = {
		loc_id: $('#loc_id').val()
	}
	
	$.post('<?php echo site::url;?>admin/ajax_locDeleteProcess',fields,function(data){

		$('td[x|='+data.x+']td[y|='+data.y+']').attr('loc_id','');
		$('td[x|='+data.x+']td[y|='+data.y+']').html('<div></div>');
	
	},'json')

	$('#zEditor').remove();

})

$('.locEditCancel').live('click',function(){
	
	$('#zEditor').remove();

})