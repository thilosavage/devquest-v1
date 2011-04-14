<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 420px; width: 660px;'>";

	echo "<div style='position: absolute; left: 22px; top: 130px; background-color: white; width: 320px; border: 5px solid black; padding: 15px;'>";
		echo "<p>You can see your stats, and see a picture of your computer setup with these buttons/keys.<br><br>";
		echo "Go forward again<br>";
	echo "</div>";
	
	echo "<div id='arrow' style='position: absolute; left: 279px; top: 430px; width: 100px; padding: 5px;'>";
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

	echo "<div id='arrow2' style='position: absolute; left: 337px; top: 430px; width: 100px; padding: 5px;'>";
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