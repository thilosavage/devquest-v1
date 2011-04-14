<?php


echo "<span class='fakelink storeSelectionShow' type='items'>Items</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

echo "<span class='fakelink storeSelectionShow' type='software'>Software</span>&nbsp;&nbsp;&nbsp;&nbsp;";

echo "<span class='fakelink storeSelectionShow' type='skills'>Skillset Books</span>&nbsp;&nbsp;&nbsp;&nbsp;";


echo "<div id='store-items'>";

	foreach ($data['items']['items'] as $k => $item) {

		echo "<div style='position: relative; border: 1px solid black; padding: 5px;' sitem_id='".$k."'>";
		echo "<table width='100%'>";
		echo "<tr>";
		echo "<td rowspan='2'><span class='itemDetailsOver'>";
		echo "<img src='".site::url."_images/items/".$item['item_id'].".png'>";
		echo "<span style='display: none; position: absolute; top: 4px; left: 4px; border: solid 1px; black; background-color: gray; padding: 10px;'>";
		
		
		foreach ($data['attribs'] as $attrib) {
			if ($item[$attrib]) {
				echo $attrib.": +".$item[$attrib]."<br>";
			}
		}
		
		if ($item['max_hp']){
			echo "HP + ".$item['max_hp']."<br>";
		}
		else if ($item['max_ram']) {
			echo "RAM + ".$item['max_ram']."<br>";
		}	
		
		
		
		echo "</span></span></td><td>";
		echo $item['name']." ($".$item['value'].")";
		echo "</td><td>";
		

		
		echo "</td><td align='right'>";
		echo "<span sitem_id='".$k."' store='1' class='fakelink itemBuyProcess store-buy'>Buy</span>";
		echo "</td></tr></table></div>";
	}

echo "</div>";

echo "<div id='store-software' style='display: none;'>";

	foreach ($data['items']['softwares'] as $software) {
		
		

		echo "<div style='border: 1px solid black; padding: 5px;'>";
		echo "<table width='100%'>";
		echo "<tr>";
		echo "<td rowspan='2'>";
		echo "<img src='".site::url."_images/software/".$software['software_id'].".png'>";
		echo "</td><td>";
		if ($software['upgrade']) {
			echo $software['name']." Version ".$software['version']."($".$software['value'].")";
		}
		else {
			echo $software['name']." Version 1 ($".$software['value'].")";
		}
		echo "</td><td>";
		
		echo "Damage: ".$software['damage']['min']." to ".$software['damage']['max']."<bR>";
		echo "RAM use: ".$software['ram'];
		
		echo "</td><td align='right'>";
		if ($software['upgrade']) {
			echo "<span software_id='".$software['software_id']."' store='1' class='fakelink softwareUpgradeProcess' style='font-size: 20px; background-color: #aaccaa; padding: 10px;'>Upgrade</span>";
		}
		else {
			echo "<span software_id='".$software['software_id']."' store='1' class='fakelink softwareBuyProcess' style='font-size: 20px; background-color: #aaccaa; padding: 10px;'>Buy</span>";
		}

		echo "</td></tr></table></div>";


	}	

echo "</div>";

echo "<div id='store-skills' style='display: none;'>";

	foreach ($data['items']['skills'] as $skill) {
		
		
		echo "<div style='border: 1px solid black; padding: 5px;'>";
		echo "<table width='100%'>";
		echo "<tr>";
		echo "<td rowspan='2'><div style='width: 70px; background: url(".site::url."_images/book.png);'>";
		echo "<img src='".site::url."_images/skills/".$skill['skill_id'].".png'></div>";
		echo "</td><td>";
		echo $skill['name']." ($".$skill['value'].")";
		echo "</td><td>";

		echo "</td><td align='right'>";
		echo "<span skill_id='".$skill['skill_id']."' store='1' class='fakelink skillBuyProcess' style='font-size: 20px; background-color: #aaccaa; padding: 10px;'>Buy</span>";
		echo "</td></tr></table></div>";	


	}		

echo "</div>";
?>