<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 420px; width: 660px;'>";

	echo "<div style='position: absolute; left: 200px; top: 315px; background-color: white; width: 400px; border: 5px solid black; padding: 15px;'>";
	
	echo "<p>The apperance of a blue up arrow means you can move forward by clicking the arrow or hitting the W key.</p>";
		
	echo "<p>Move forward now.</p>";

	echo "</div>";
		
	echo "<div id='arrow' style='position: absolute; left: 38px; top: 430px; width: 100px; padding: 5px;'>";
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