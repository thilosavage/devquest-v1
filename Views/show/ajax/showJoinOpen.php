<?php
echo "<div class='action-header'>Attend a show</div>";
foreach ($shows as $show){
	echo "<div class='show-entry'>";
		echo "<span class='show-name'>".$show['name']."</span>";
		echo "<span class='show-attend showJoinProcess fakelink' show_id='".$show['show_id']."' style='float: right'>Attend</span>";
	echo "</div>";
}
?>