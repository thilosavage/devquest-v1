<?php

echo "<div class='showNewForm fakelink'>Create New Show</div>";

foreach ($shows as $show){
	echo "<div class='show-my-row'>";
	echo "<span class='show-my-name'>".$show['name']."</span>";
	echo "<span class='show-my-end'>Ends: ".date::unixToFancy($show['end'])."</span>";
	echo "<span style='float: right;' class='showInfoLoad fakelink' show_id='".$show['show_id']."'>Manage</span>";
	echo "<span style='float: right;' class='show-my-size'>".$show['size']." attending</span>";
	echo "</div>";
}

?>