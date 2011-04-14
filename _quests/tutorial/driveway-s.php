<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 420px; width: 660px;'>";

	echo "<div style='position: absolute; left: 302px; top: 100px; background-color: white; width: 360px; border: 5px solid black; padding: 15px;'>";
		echo "<p>To look at your inventory, hit B or click the button with a bag on it.<br>";
		echo "You already have a mouse. Equip it. Now your stats are increased. Move forward.<br>";
	echo "</div>";
	
	echo "<div id='arrow' style='position: absolute; left: 162px; top: 430px; width: 100px; padding: 5px;'>";
		echo "<img src='".site::url."_images/arrow-d.png'>";
		?>
		<script>
		$(function(){
			$('#arrow').animate({top: '-=20'},500,'',function(){
				$('#arrow').animate({top: '+=15'},500,'',function(){
					$('#arrow').animate({top: '-=10'},500,'',function(){
						$('#arrow').animate({top: '+=10'},500,'',function(){
						});						
					});					
				});			
			});
		});
		</script>

		<?php
	echo "</div>";	

	echo "</div>";

echo "</div>";
?>