<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 420px; width: 660px;'>";

	echo "<div style='position: absolute; left: 352px; top: 80px; background-color: white; width: 360px; border: 5px solid black; padding: 15px;'>";
		echo "Le Petite Bakery is offering your first web design gig. But first, you have to meet the requirements.<br><br>";
		
		echo "Turn around, go forward, and I'll show you how.";
		
	echo "</div>";
	
	echo "<div id='arrow' style='position: absolute; left: 90px; top: 130px; width: 100px; padding: 5px;'>";
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