<?php



echo "<div id='gig-window' style='border: 1px solid black; padding: 10px; background-color: #99ccff;'>";

	echo "<div id='gig-header'><strong>There is a freelance gig available here.</strong></div>";
	

	echo "Description: ".$data['desc']."<br>";
	
	echo "<strong>Requirements:</strong><br>";
	
	echo "<div id='gig-requirements' style='font-size: 13px; padding-left: 20px; '>";

		//echo "<b3>We are looking for someone who is at least level ".$data['level']." and -<br></b3>";
	

		echo "<table cellpadding='8'><tr><td valign='top'>";
		
		if ($data['requirements']['skills']) {
			
			echo "<h5>Skills</h5>";
			foreach ($data['requirements']['skills'] as $skill => $level) {
			
				if ($level['fail']) {
					echo "<img src='".site::url."_images/x.png'>";
				}
				else {
					echo "<img src='".site::url."_images/check.png'>";
				}
				
				echo $level['need']." at ".$skill."<br><span style='font-size: 11px;'>(Currently ".$level['current'].")</span><br>"; 
			}
			
			echo "</td><td valign='top'>";
		}
		
		if ($data['requirements']['software']) {
			
			echo "<h5>Software</h5>";
			foreach ($data['requirements']['software'] as $software=> $version) {
			
				if ($version['fail']) {
					echo "<img src='".site::url."_images/x.png'>";
				}
				else {
					echo "<img src='".site::url."_images/check.png'>";
				}		
			
				echo "Version ".$version['need']." of ".$software."<br><span style='font-size: 11px;'>(Currently ".$version['current'].")</span><br>"; 
			}
			
			echo "</td><td valign='top'>";
		}
		
		if ($data['requirements']['stats']) {
			echo "<h5>Stats</h5>";
			foreach ($data['requirements']['stats'] as $stat => $level) {
			
				if ($level['fail']) {
					echo "<img src='".site::url."_images/x.png'>";
				}
				else {
					echo "<img src='".site::url."_images/check.png'>";
				}
				
				echo "Have ".$level['need']." ".$stat."<br><span style='font-size: 11px;'>(Currently ".$level['current'].")</span><br>";
			}
		}
		
		echo "</td></tr></table>";	
	
	
		
	echo "</div>";
	
	
	if ($data['qualified']){

		echo "<div class='fakelink gigApplyProcess' style='text-align: right; '>Take this gig</div>";

	}
	else {

		echo "<div style='color: gray; text-align: right; text-decoration: underline;'>You are not qualified for this gig</div>";

	}

echo "</div>";


?>