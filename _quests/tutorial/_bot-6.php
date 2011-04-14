<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 0px; width: 0px;'>";

	echo "<div style='position: absolute; left: 259px; top: 100px; background-color: white; width: 250px; border: 5px solid black; padding: 15px;'>";
	
		echo "Hurry! Fix Dustin's computer before you run out of hp)<br><br>";
		
		echo "Select your Dusting skill from below and click the Overheating issue.<br><br>";
		
		echo "Once the problem is gone, you will gain exp, items, etc<br><br>";
		
	echo "</div>";
	
	
	echo "<div id='arrow' style='position: absolute; left: 164px; top: 147px; width: 100px; padding: 5px;'>";
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

	echo "<div id='arrow2' style='position: absolute; left: 71px; top: 266px; width: 100px; padding: 5px;'>";
		echo "<img src='".site::url."_images/arrow-d.png'>";
		?>
		<script>
		$(function(){
			$('#arrow2').animate({top: '-=20'},500,'',function(){
				$('#arrow2').animate({top: '+=15'},500,'',function(){
					$('#arrow2').animate({top: '-=10'},500,'',function(){
						$('#arrow2').animate({top: '+=10'},500,'',function(){
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