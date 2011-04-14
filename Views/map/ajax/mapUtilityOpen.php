<?php

$ret .=  "<table>";
for ($y=1;$y<=8;$y++) {

	$ret .=  "<tr>";
	
	for ($x=1;$x<=17;$x++) {
		if ($coords[$x][$y]['name']) {
			$ret .=  "<td style='font-size: 8px; width: 12px; height: 14px; padding: 0px; border: 1px solid black;' class='fakelink locDetailsOpen map-loc' x=".$x." y=".$y." loc_id='".$coords[$x][$y]['loc_id']."'>";
			$ret .=  "<div>";

			//$ret .=  substr($coords[$x][$y]['name'],0,8);
			$ret .=  "</div>";
			$ret .=  "</td>";
		}
		else {
			$ret .=  "<td>";
			$ret .=  "</td>";
		}
	
	}
	$ret .=  "</tr>";
}
$ret .=  "</table>";

echo $ret;
?>