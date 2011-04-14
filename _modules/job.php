<?php

echo "<div id='job-window' style='border: 1px solid black; padding: 10px; background-color: #aa88ff;'>";

	if ($data['employed']) {
		
		echo "<div id='job-header'><strong>You are currently employed here.</strong></div>";
		
		//echo "<div class='fakelink jobWorkStart'>Work</div>";
		
		echo "<div id='work-status'></div>";
		 
	}
	else {
	
		echo "<div id='job-header'><strong>".$data['name']." is hiring!</strong></div>";
		
		echo $data['desc']."<br>";

		echo "<div id='job-header'>This job requires:</div>";
		
		echo "<div id='job-requirements' style='font-size: 13px; padding-left: 20px; '>";

		
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
		
		echo "<div id='job-header'>This job offers:</div>";
		
		echo "<div id='job-requirements' style='font-size: 13px; padding-left: 20px; '>";		
		

		
		echo "<table cellpadding='8'><tr><td valign='top'>";
		
		echo "Processor increased by ".$data['offers']['stat']['processor'];

		
		echo "</td></tr></table>";		
		
		
		
		
		
		echo "</div>";
		
		
		if ($data['qualified']){
			echo "<div class='fakelink jobApplyProcess' style='text-align: right';>Apply for this job</div>";
		}
		else {
			echo "<div style='color: gray; text-decoration: underline; text-align: right;'>You are not qualified for this position</div>";
		}
	}

echo "</div>";

?>