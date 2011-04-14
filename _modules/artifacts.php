<?php



if ($data['key']) {
	echo "<div id='artifacts' class='world-freebox'>";
	echo "<span key='".$data['key']."' class='fakelink pickup worldItemPickup'><img src='".site::url."_images/freebox.png'></span>";
	echo "</div>";
}
else {
	echo "<div id='artifacts' class='world-freebox'>";
	echo "<span key='".$data['key']."' class='pickup'><img src='".site::url."_images/freebox-open.png'></span>";
	echo "</div>";
}



?>