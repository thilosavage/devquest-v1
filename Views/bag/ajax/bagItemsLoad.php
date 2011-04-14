<?php

echo "<h3>Items</h3>";

if ($items){

	
	echo "<table>";
	
	$i = 0;
	foreach ($items as $item){
	
		$usable = false;
		

		
		if ($i%3 == 0){
			echo "<tr item_user_id='".$item['item_user_id']."'>";
		}		
		
		if ($item['equipped']) {
			echo "<td><table item_user_id='".$item['item_user_id']."' width='240' style='border: 1px solid black; background-color: yellow; padding: 5px;'><tr><td>";
		}
		else {
			echo "<td><table item_user_id='".$item['item_user_id']."' width='240' style='border: 1px solid black; padding: 5px;'><tr><td>";
		}		
		

		echo "<div class='itemDetailsOver' style='position: relative;'>";
		
		if ($item['type'] == 'monitor') {
			echo "<img width='220' src='".site::url."_images/items/".$item['item_id'].".png'>";			
		}
		else if ($item['type'] == 'keyboard') {
			echo "<img width='220' src='".site::url."_images/items/".$item['item_id'].".png'>";			
		}	
		else {
			echo "<img src='".site::url."_images/items/".$item['item_id'].".png'>";
		}
		
		
		echo "<span style='z-index: 10; display: none; position: absolute; top: 4px; left: 4px; border: solid 1px; black; background-color: gray; padding: 10px;'>";
		
		echo "<div>".$item['name']."</div>";
		
		if ($item['quantity'] > 1) {
			echo " (".$item['quantity'].")";
		}
		
		if ($item['attribs']) {
			foreach ($item['attribs'] as $attrib => $value){
				echo $attrib.": +".$value."<br>";
			}
		}
		if ($item['hp']){
			echo "HP + ".$item['hp']."<br>";
			$usable = true;
		}
		else if ($item['ram']) {
			echo "RAM + ".$item['ram']."<br>";
			$usable = true;
		}		
	
		
		echo "<br>";
		
		if ($usable) {
			echo "<span item_id='".$item['item_id']."' class='fakelink itemUseProcess' style='font-size: 20px; background-color: #aaccaa; padding: 10px;'>Use</span>";
		}
		else if ($item['equipped']) {
			echo "<span item_user_id='".$item['item_user_id']."' class='fakelink itemUnequipProcess' style='font-size: 20px; background-color: #bbaabb; padding: 10px;'>Unequip</span>";
		}
		else if ($item['type']) {
			echo "<span item_user_id='".$item['item_user_id']."' class='fakelink itemEquipProcess' style='font-size: 20px; background-color: #aaccaa; padding: 10px;'>Equip</span>";
			
			if (!$_SESSION['store']['store_id']) {
			
				echo "<span item_user_id='".$item['item_user_id']."' class='fakelink itemDestroyProcess' style='font-size: 20px; background-color: #ffcccc; padding: 10px;'>Destroy</span>";
			}
			
		}		
		if ($_SESSION['store']['store_id'] && (!$item['equipped'] || $usable)) {

			echo "<span item_user_id='".$item['item_user_id']."' class='fakelink itemSellProcess' style='font-size: 20px; background-color: #99ccff; padding: 10px;'>Sell for $".$item['value']."</span>";
		
		}

		echo "</span>";		

		echo "</div>";
		
		echo "</td></tr></table></td><td align='right'>";
		
		echo "</td>";
		if ($i%3 == 3){
			echo "</tr>";
		}
		
		$i++;
		
	}
	echo "</table>";
	echo "<br><br><br><br><br>";
}
else {
	echo "<div>Bag is empty</div>";
}

?>