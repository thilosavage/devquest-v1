<?php

$posLeft = 5;

foreach ($data['data'] as $bot){
	
	echo "<div style='position: absolute; background-color: black; left: ".$posLeft."; border: black solid 3px; height: 110px; width: 132px' bot_id='".$bot['bot_id']."' class='fakelink botTalkOpen'>";
	

	//$im = imagecreatefromjpeg("https://graph.facebook.com/".$bot['fbid']."/picture?type=large");
	//$x = imagesx($im);
	//$y = imagesy($im);

	//$size = getimagesize("https://graph.facebook.com/".$bot['fbid']."/picture?type=large");
	
	
	echo "<span style='position: absolute; text-align: center; width: 132px;'>";
	
	echo "<span><img src='https://graph.facebook.com/".$bot['fbid']."/picture?type=large' style='max-width: 132; max-height: 110;'></span>";
	echo "<span><img src='".site::url."_images/zombify.png' style='position: absolute; top: -3px; left: -2px;'></span>";
	
	
	echo "</span>";

	

	echo "<span style='background-color: gray; color: white; font-size: 12px; padding: 2px; position: absolute; top: 88px; text-decoration: none;'>";
	echo $bot['name'];
	echo "</span><br>";
	//echo "<span style='background-color: gray; color: yellow; padding: 5px; position: absolute; top: 3px; left: 80px; '>Talk</span>";
	echo "</div>";
	
	$posLeft += 160;
	
}
?>