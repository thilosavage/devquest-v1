<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 0px; width: 0px;'>";

	echo "<div style='position: absolute; left: 200px; top: 210px; background-color: white; width: 400px; border: 5px solid black; padding: 15px;'>";
	
		echo "You are in your house right now. Click 'sleep' to reset your HP and RAM, and reset the map.";
		echo "<br><br>Turn left again";

	echo "</div>";
	
	echo "<div id='arrow' style='position: absolute; left: 125px; top: 61px; width: 100px; padding: 5px;'>";
		echo "<img src='".site::url."_images/arrow-dl.png'>";
		?>
		<script>
		$(function(){
			$('#arrow').animate({left: '-=20'},500,'',function(){
				$('#arrow').animate({left: '+=15'},500,'',function(){
					$('#arrow').animate({left: '-=10'},500,'',function(){
						$('#arrow').animate({left: '+=10'},500,'',function(){
						});
					});
				});
			});
		});
		</script>

		<?php
	echo "</div>";		

echo "</div>";
?>