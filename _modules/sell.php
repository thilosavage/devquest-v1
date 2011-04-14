<?php
echo "<div id='bot-talk-content' style='border: 1px solid black; background-color: yellow; padding: 0px; margin-top: 20px; height: 338px;'>";

if ($data['sells']){

	echo "<span style='position: absolute; top: 45px; left: 45px;'><img src='https://graph.facebook.com/".$data['bot']['fbid']."/picture?type=small'></span>";
	echo "<h5 style='position: absolute; top: 14px; left: 109px;'>I have this stuff I don't use.. I'll sell it to you if you want.</h5>";
}

echo "<div id='sell-panel'>";

if ($data['sells']){
	echo "<table><tr>";
	
	if ($data['sells']['skill']){
		echo "<td valign='top'><div id='sell-target' skill_id='".$data['sells']['skill']['skill_id']."'>";
		
			echo "<img src='".site::url."_images/skills/".$data['sells']['skill']['skill_id'].".png'><br>";	
			echo $data['sells']['skill']['name']." book ($".$data['sells']['skill']['value'].")<br>";
			echo "<div skill_id='".$data['sells']['skill']['skill_id']."' store='0' class='sell-buy fakelink skillBuyProcess'>Buy</div>";
		
		echo "</div></td>";

	}
	
	if ($data['sells']['software']){
		echo "<td valign='top'><div id='sell-target' software_id='".$data['sells']['software']['software_id']."'>";
		
			echo "<img src='".site::url."_images/software/".$data['sells']['software']['software_id'].".png'><br>";	
			echo $data['sells']['software']['name']." ($".$data['sells']['software']['value'].")<br>";
			echo "<div software_id='".$data['sells']['software']['software_id']."' store='0' class='sell-buy fakelink softwareBuyProcess'>Buy</div>";
		
		echo "</div></td>";
	}
	
	if ($data['sells']['item']){

		echo "<td valign='top'><div id='sell-target' sitem_id='".$data['sells']['item']['item_id']."'>";
		
			echo "<img src='".site::url."_images/items/".$data['sells']['item']['item_id'].".png'><br>";
			echo $data['sells']['item']['name']."($".$data['sells']['item']['value'].")<br>";
			echo "<div sitem_id='".$data['sells']['item']['item_id']."' store='0' class='sell-buy fakelink itemBuyProcess'>Buy</div>";
			
		echo "</div></td>";

	}	
	
	echo "</tr></table>";
}
else {
	echo "<span style='position: absolute; top: 1px; left: 45px;'><img src='https://graph.facebook.com/".$data['bot']['fbid']."/picture?type=large'></span>";
	echo "<h3 style='position: absolute; top: 14px; left: 309px;'>Leave me alone...</h3>";
}

echo "</div>";

echo "<span id='leave-fight' style='position: absolute; left: 644px; top: 333px; width: 126px;' class='fakelink fightCloseProcess'>Walk away</span>";

echo "</div>";

?>