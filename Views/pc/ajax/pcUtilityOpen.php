<?php

$attribs = settings::$stattribs;

foreach ($parts as $k => $part) {

	$parts[$k] = $part;
	$parts[$k]['disp'] = "<span style='z-index: 10; display: none; border: solid 1px; black; font-size: 13px; background-color: gray; padding: 10px; position: absolute; top: 20px; left: 50px;'>";
	$parts[$k]['disp'] .= "<div style='font-size: 16px;'>".$part['name']."</div>";
	
	foreach ($attribs as $attrib) {
		if ($part[$attrib]) {
			$parts[$k]['disp'] .= $attrib.": +".$part[$attrib]."<br>";
			$score = $score + $part[$attrib];
		}
	}
	
	if ($part['max_hp']){
		$parts[$k]['disp'] .= "HP + ".$part['max_hp']."<br>";
	}
	else if ($part['max_ram']) {
		$parts[$k]['disp'] .= "RAM + ".$part['max_ram']."<br>";
	}
	
	$parts[$k]['disp'] .= "</span>";

}


echo "<h4>Your Setup</h4>";

echo "<div>";

if ($parts['keyboard']['item_id']) {
	echo "<div class='itemDetailsOver' style='position: absolute; left: 198px; top: 379px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['keyboard']['item_id'].".png'>";
	echo $parts['keyboard']['disp'];
	echo "</div>";
}

if ($parts['mouse']['item_id']) {
	echo "<div class='itemDetailsOver' style='z-index: 2; position: absolute; left: 598px; top: 390px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['mouse']['item_id'].".png'>";
	echo $parts['mouse']['disp'];
	echo "</div>";
}

if ($parts['monitor']['item_id']) {
	echo "<div class='itemDetailsOver' style='position: absolute; left: 233px; top: 234px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['monitor']['item_id'].".png'>";
	echo $parts['monitor']['disp'];
	echo "</div>";
	
}

if ($parts['speakers']['item_id']) {
	echo "<div class='itemDetailsOver' style='position: absolute; left: 77px; top: 296px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['speakers']['item_id'].".png'>";
	echo $parts['speakers']['disp'];
	echo "</div>";
}

if ($parts['mousepad']['item_id']) {
	echo "<div class='itemDetailsOver' style='position: absolute; left: 554px; top: 409px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['mousepad']['item_id'].".png'>";
	echo $parts['mousepad']['disp'];
	echo "</div>";
}

if ($parts['tower']['item_id']) {
	echo "<div class='itemDetailsOver' style='position: absolute; left: 542px; top: 181px; width: 200px; height: 50px;'>";
	echo "<img src='".site::url."_images/items/".$parts['tower']['item_id'].".png'>";
	echo $parts['tower']['disp'];
	echo "</div>";
}



echo "<img src='".site::url."_images/pc-temp.png'>";

echo "</div>";

$score = ceil($score * 3 / 2);
$score = $score?$score:'0';
echo "<p>Your computer has a score of ".$score.".</p>";
echo "<p>Mouse over your gear to see the specs</p>";
?>