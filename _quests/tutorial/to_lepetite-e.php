<?php

echo "<div class='quest' style='position: absolute; top: 0px; left: 0px; z-index: 400; height: 420px; width: 660px;'>";

	echo "<div style='position: absolute; left: 161px; top: 141px; background-color: white; width: 260px; border: 5px solid black; padding: 15px;'>";

		echo "<p>See me down here? Click on me to fix my computer and get experience and stuff.</p>";
		
	echo "</div>";
	
	echo "<div id='arrow' style='position: absolute; left: 251px; top: 285px; width: 100px; padding: 5px;'>";
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