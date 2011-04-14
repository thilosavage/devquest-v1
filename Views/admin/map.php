<?php
echo "<table>";
for ($y=1;$y<=25;$y++) {

	echo "<tr>";
	
	for ($x=1;$x<=35;$x++) {
		if ($xs[$x][$y]['name']) {
			echo "<td style='font-size: 8px; width: 40px; height: 40px; padding: 1px; border: 1px solid black; ";
			
			if ($xs[$x][$y]['level']) {
				$lev = 10-$xs[$x][$y]['level'];
				$lev = $lev.$lev.$lev.$lev;
				echo "background-color: #ff".$lev;
			}
			else {
			
			}
			
			echo "' class='locEditOpen' x=".$x." y=".$y." loc_id='".$xs[$x][$y]['loc_id']."'>";
			echo "<div '>";
			echo $xs[$x][$y]['loc_id'].'<br>'.substr($xs[$x][$y]['name'],0,8)."<br>".$xs[$x][$y]['level'];
			
			if ($xs[$x][$y]['has_artifacts']) {
				echo "<span style='float: right'>[][]</span>";
			}
			
			echo "</div>";
			echo "</td>";
		}
		else {
			echo "<td style='font-size: 8px; width: 40px; height: 40px; padding: 1px; border: 1px solid #222222;' class='locEditOpen' x=".$x." y=".$y." loc_id='".$xs[$x][$y]['loc_id']."'>";
			echo "<div '>";
			echo substr($xs[$x][$y]['name'],0,8)."<br>".$xs[$x][$y]['loc_id'];
			echo "</div>";
			echo "</td>";
		}
		
	
	}
	echo "</tr>";
}
echo "</table>";
?>