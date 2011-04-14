<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 0px; width: 0px;'>";

	echo "<div style='position: absolute; left: 200px; top: 210px; background-color: white; width: 400px; border: 5px solid black; padding: 15px;'>";
	echo "Help!<br><br>The city of Missoula is in technological shambles.<br><br>Nobody knows anything about computers, and they need your help.<br><br>";
	echo "First, turn left by hitting the blue arrow key pointing to the left.";

	
	echo "</div>";
	
	
	echo "<div id='arrow' style='position: absolute; left: -11px; top: 430px; width: 100px; padding: 5px;'>";
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
?>