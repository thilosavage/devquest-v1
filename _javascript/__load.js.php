<script>

window.fbAsyncInit = function() {

	FB.init({
		apiKey: '<?php echo site::fbapp_id; ?>',
		status: true,
		cookie: true,
		xfbml: true
	});

	FB.Event.subscribe('auth.login', function(response) {
		worldLoginProcess('redirect');
	});
	FB.Event.subscribe('auth.logout', function(response) {
		worldLogoutProcess();
	});

	FB.getLoginStatus(function(response) {
		if (response.session) {
			worldLoginProcess('');
		}
	});
	
};
	
$(document).ready(function(){

	var e = document.createElement('script');
	e.type = 'text/javascript';
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	e.async = true;
	document.getElementById('fb-root').appendChild(e);

	document.bearing = '<?php echo settings::initial_bearing; ?>';
	document.loc_id = <?php echo settings::initial_home; ?>;
	
	//worldMoverProcess();
	worldReviveProcess()
	
	$('#action-container').css('opacity','.5');
	$('#action').css('opacity','1');
	
	
	
	
	document.allow_move = false;
	document.allow_turn = true;
	
	$(document).keyup(function(e) {
		
		  if(e.which == 37 || e.which == 65) {
			worldTurnProcess('l');
		  }
		  if (e.which == 39 || e.which == 68) {
		  worldTurnProcess('r');
		  }
		  if ((e.which == 38 || e.which == 87) && document.allow_move == true) {
		  worldMoverProcess();
		  }	
		  
		  if (e.which == 88) {
			fightCloseProcess();
		  }
 
		  if (e.which == 90) {
			bagUtilityOpen();
		  }
		  
		  if (e.which == 67) {
			mapUtilityOpen();
		  }		  
 

	});
	
	worldZombifyProcess()
	
	
});

var userAttack;


</script>